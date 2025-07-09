<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use App\Models\EmploiDuTemps;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalleController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the classrooms.
     */
    public function index()
    {
        $salles = Salle::all();
        return view('salles.index', compact('salles'));
    }

    /**
     * Show the form for creating a new classroom.
     */
    public function create()
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('salles.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de créer des salles.');
        }
        
        return view('salles.create');
    }

    /**
     * Store a newly created classroom in storage.
     */
    public function store(Request $request)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('salles.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de créer des salles.');
        }
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'etage' => 'nullable|string|max:50',
            'capacite' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'est_disponible' => 'boolean',
        ]);
        
        Salle::create($validated);
        
        return redirect()->route('salles.index')
            ->with('success', 'Salle créée avec succès.');
    }

    /**
     * Display the specified classroom.
     */
    public function show(Salle $salle)
    {
        $jourActuel = strtolower(Carbon::now()->locale('fr')->dayName);
        $emploiDuJour = EmploiDuTemps::where('salle_id', $salle->id)
            ->where('jour', $jourActuel)
            ->where('est_actif', true)
            ->orderBy('heure_debut')
            ->get();
            
        $formationActuelle = $salle->formationActuelle();
        $prochaineFormation = $salle->prochainFormation();
        
        return view('salles.show', compact('salle', 'emploiDuJour', 'formationActuelle', 'prochaineFormation'));
    }

    /**
     * Show the form for editing the specified classroom.
     */
    public function edit(Salle $salle)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('salles.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de modifier des salles.');
        }
        
        return view('salles.edit', compact('salle'));
    }

    /**
     * Update the specified classroom in storage.
     */
    public function update(Request $request, Salle $salle)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('salles.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de modifier des salles.');
        }
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'etage' => 'nullable|string|max:50',
            'capacite' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'est_disponible' => 'boolean',
        ]);
        
        $salle->update($validated);
        
        return redirect()->route('salles.index')
            ->with('success', 'Salle mise à jour avec succès.');
    }

    /**
     * Remove the specified classroom from storage.
     */
    public function destroy(Salle $salle)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('salles.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de supprimer des salles.');
        }
        
        
        $hasSchedule = EmploiDuTemps::where('salle_id', $salle->id)->exists();
        
        if ($hasSchedule) {
            return redirect()->route('salles.index')
                ->with('error', 'Impossible de supprimer cette salle car elle est utilisée dans l\'emploi du temps.');
        }
        
        $salle->delete();
        
        return redirect()->route('salles.index')
            ->with('success', 'Salle supprimée avec succès.');
    }

    /**
     * Display the schedule for all classrooms.
     */
    public function emploiDuTemps()
    {
        $salles = Salle::where('est_disponible', true)->get();
        $formations = Formation::all();
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        
        $emploiParJour = [];
        
        foreach ($jours as $jour) {
            $emploiParJour[$jour] = EmploiDuTemps::with(['formation', 'salle'])
                ->where('jour', $jour)
                ->where('est_actif', true)
                ->orderBy('heure_debut')
                ->get();
        }
        
        return view('salles.emploi-du-temps', compact('salles', 'formations', 'jours', 'emploiParJour'));
    }

    /**
     * Check if a classroom is available at a specific time.
     */
    public function checkAvailability(Request $request)
    {
        $validated = $request->validate([
            'salle_id' => 'required|exists:salles,id',
            'jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'emploi_id' => 'nullable|exists:emploi_du_temps,id',
        ]);
        
        $salle = Salle::findOrFail($validated['salle_id']);
        
        $isAvailable = EmploiDuTemps::isSalleAvailable(
            $validated['salle_id'],
            $validated['jour'],
            $validated['heure_debut'],
            $validated['heure_fin'],
            $validated['emploi_id'] ?? null
        );
        
        return response()->json([
            'isAvailable' => $isAvailable && $salle->est_disponible,
            'salle' => $salle->nom,
        ]);
    }
}
