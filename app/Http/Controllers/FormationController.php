<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Formateur;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the formations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formations = Formation::with('formateur')->get();
        return view('formations.index', compact('formations'));
    }

    /**
     * Show the form for creating a new formation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('formations.index')
                ->with('error', 'Vous n\'avez pas la permission de créer des formations.');
        }
        
        $formateurs = Formateur::all();
        $niveauxLangue = Formation::$niveauxLangue;
        $langues = ['français', 'anglais', 'espagnol', 'allemand', 'italien', 'arabe', 'chinois', 'japonais', 'russe'];
        
        return view('formations.create', compact('formateurs', 'niveauxLangue', 'langues'));
    }

    /**
     * Store a newly created formation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('formations.index')
                ->with('error', 'Vous n\'avez pas la permission de créer des formations.');
        }
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau_langue' => 'required|string|in:A1,A2,B1,B2,C1,C2',
            'langue' => 'required|string|max:255',
            'prix_mensuel' => 'required|numeric|min:0',
            'duree_mois' => 'required|integer|min:1',
            'places_maximum' => 'required|integer|min:1',
            'formateur_id' => 'required|exists:formateurs,id',
        ]);

        $data = $request->all();
        $data['places_disponibles'] = $request->places_maximum;
        
        
        $niveauxMap = [
            'A1' => 'Débutant',
            'A2' => 'Élémentaire',
            'B1' => 'Intermédiaire',
            'B2' => 'Intermédiaire supérieur',
            'C1' => 'Avancé',
            'C2' => 'Maîtrise'
        ];
        
        $data['niveau'] = $niveauxMap[$request->niveau_langue] ?? 'Débutant';
        
        Formation::create($data);

        return redirect()->route('formations.index')
            ->with('success', 'Formation créée avec succès.');
    }

    /**
     * Display the specified formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function show(Formation $formation)
    {
        $formation->load(['formateur', 'eleves', 'emploiDuTemps.salle']);
        
        $elevesPayes = $formation->elevesPayesPourMoisCourant()->get();
        $elevesNonPayes = $formation->elevesNonPayesPourMoisCourant()->get();
        
        return view('formations.show', compact('formation', 'elevesPayes', 'elevesNonPayes'));
    }

    /**
     * Show the form for editing the specified formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function edit(Formation $formation)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('formations.index')
                ->with('error', 'Vous n\'avez pas la permission de modifier des formations.');
        }
        
        $formateurs = Formateur::all();
        $niveauxLangue = Formation::$niveauxLangue;
        $langues = ['français', 'anglais', 'espagnol', 'allemand', 'italien', 'arabe', 'chinois', 'japonais', 'russe'];
        
        return view('formations.edit', compact('formation', 'formateurs', 'niveauxLangue', 'langues'));
    }

    /**
     * Update the specified formation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formation $formation)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('formations.index')
                ->with('error', 'Vous n\'avez pas la permission de modifier des formations.');
        }
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau_langue' => 'required|string|in:A1,A2,B1,B2,C1,C2',
            'langue' => 'required|string|max:255',
            'prix_mensuel' => 'required|numeric|min:0',
            'duree_mois' => 'required|integer|min:1',
            'places_maximum' => 'required|integer|min:1',
            'formateur_id' => 'required|exists:formateurs,id',
        ]);

        $data = $request->all();
        
        
        if ($formation->places_maximum != $request->places_maximum) {
            $elevesActifsCount = $formation->elevesActifs()->count();
            $data['places_disponibles'] = max(0, $request->places_maximum - $elevesActifsCount);
        }
        
        $formation->update($data);

        return redirect()->route('formations.index')
            ->with('success', 'Formation mise à jour avec succès.');
    }

    /**
     * Remove the specified formation from storage.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formation $formation)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('formations.index')
                ->with('error', 'Vous n\'avez pas la permission de supprimer des formations.');
        }
        
        $formation->delete();

        return redirect()->route('formations.index')
            ->with('success', 'Formation supprimée avec succès.');
    }

    /**
     * Display the list of students enrolled in the formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function eleves(Formation $formation)
    {
        $formation->load('eleves');
        
        $elevesActifs = $formation->elevesActifs()->get();
        $elevesInactifs = $formation->eleves()
            ->wherePivot('statut', '!=', 'actif')
            ->get();
        
        $elevesPayes = $formation->elevesPayesPourMoisCourant()->get();
        $elevesNonPayes = $formation->elevesNonPayesPourMoisCourant()->get();
        
        return view('formations.eleves', compact('formation', 'elevesActifs', 'elevesInactifs', 'elevesPayes', 'elevesNonPayes'));
    }

    /**
     * Show the form for enrolling a student in the formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function inscriptionForm(Formation $formation)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('formations.show', $formation)
                ->with('error', 'Vous n\'avez pas la permission d\'inscrire des élèves.');
        }
        
        $eleves = Eleve::whereDoesntHave('formations', function($query) use ($formation) {
            $query->where('formation_id', $formation->id);
        })->get();
        
        return view('formations.inscription', compact('formation', 'eleves'));
    }

    /**
     * Enroll a student in the formation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function inscription(Request $request, Formation $formation)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('formations.show', $formation)
                ->with('error', 'Vous n\'avez pas la permission d\'inscrire des élèves.');
        }
        
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'date_inscription' => 'required|date',
        ]);
        
        
        if (!$formation->hasPlacesDisponibles()) {
            return redirect()->route('formations.inscriptionForm', $formation)
                ->with('error', 'Il n\'y a plus de places disponibles dans cette formation.');
        }

        $formation->eleves()->attach($request->eleve_id, [
            'date_inscription' => $request->date_inscription,
            'statut' => 'actif',
        ]);
        
        
        $formation->updatePlacesDisponibles();

        return redirect()->route('formations.eleves', $formation)
            ->with('success', 'Élève inscrit avec succès.');
    }

    /**
     * Update the enrollment status of a student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @param  \App\Models\Eleve  $eleve
     * @return \Illuminate\Http\Response
     */
    public function updateStatut(Request $request, Formation $formation, Eleve $eleve)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('formations.eleves', $formation)
                ->with('error', 'Vous n\'avez pas la permission de modifier le statut des élèves.');
        }
        
        $request->validate([
            'statut' => 'required|in:actif,inactif,suspendu',
        ]);
        
        $oldStatut = $formation->eleves()->where('eleve_id', $eleve->id)->first()->pivot->statut;

        $formation->eleves()->updateExistingPivot($eleve->id, [
            'statut' => $request->statut,
        ]);
        
        
        if (($oldStatut === 'actif' && $request->statut !== 'actif') || 
            ($oldStatut !== 'actif' && $request->statut === 'actif')) {
            $formation->updatePlacesDisponibles();
        }

        return redirect()->route('formations.eleves', $formation)
            ->with('success', 'Statut de l\'élève mis à jour avec succès.');
    }
    
    /**
     * Display the list of students who have paid for the current month.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function elevesPayes(Formation $formation)
    {
        $elevesPayes = $formation->elevesPayesPourMoisCourant()->get();
        return view('formations.eleves-payes', compact('formation', 'elevesPayes'));
    }
    
    /**
     * Display the list of students who have not paid for the current month.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function elevesNonPayes(Formation $formation)
    {
        $elevesNonPayes = $formation->elevesNonPayesPourMoisCourant()->get();
        return view('formations.eleves-non-payes', compact('formation', 'elevesNonPayes'));
    }
    
    /**
     * Filter formations by language level.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterByLevel(Request $request)
    {
        $niveau = $request->niveau_langue;
        $langue = $request->langue;
        
        $query = Formation::query();
        
        if ($niveau) {
            $query->where('niveau_langue', $niveau);
        }
        
        if ($langue) {
            $query->where('langue', $langue);
        }
        
        $formations = $query->with('formateur')->get();
        $niveauxLangue = Formation::$niveauxLangue;
        $langues = ['français', 'anglais', 'espagnol', 'allemand', 'italien', 'arabe', 'chinois', 'japonais', 'russe'];
        
        return view('formations.index', compact('formations', 'niveauxLangue', 'langues', 'niveau', 'langue'));
    }
}
