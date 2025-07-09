<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Formation;
use App\Models\Salle;
use App\Models\Formateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmploiDuTempsController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the schedules.
     */
    public function index()
    {
        $emploiDuTemps = EmploiDuTemps::with(['formation', 'salle'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();
            
        return view('emploi-du-temps.index', compact('emploiDuTemps'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('emploi-du-temps.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de créer des emplois du temps.');
        }
        
        $formations = Formation::all();
        $salles = Salle::where('est_disponible', true)->get();
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        
        return view('emploi-du-temps.create', compact('formations', 'salles', 'jours'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('emploi-du-temps.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de créer des emplois du temps.');
        }
        
        $validated = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'salle_id' => 'required|exists:salles,id',
            'jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);
        
        
        $isAvailable = EmploiDuTemps::isSalleAvailable(
            $validated['salle_id'],
            $validated['jour'],
            $validated['heure_debut'],
            $validated['heure_fin']
        );
        
        if (!$isAvailable) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La salle n\'est pas disponible à cette heure.');
        }
        
        
        $formation = Formation::findOrFail($validated['formation_id']);
        $formateurId = $formation->formateur_id;
        
        $formateurOccupe = EmploiDuTemps::whereHas('formation', function ($query) use ($formateurId) {
                $query->where('formateur_id', $formateurId);
            })
            ->where('jour', $validated['jour'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('heure_debut', '<', $validated['heure_fin'])
                      ->where('heure_fin', '>', $validated['heure_debut']);
                });
            })
            ->exists();
            
        if ($formateurOccupe) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Le formateur n\'est pas disponible à cette heure.');
        }
        
        EmploiDuTemps::create($validated);
        
        return redirect()->route('emploi-du-temps.index')
            ->with('success', 'Emploi du temps créé avec succès.');
    }

    /**
     * Display the specified schedule.
     */
    public function show(EmploiDuTemps $emploiDuTemp)
    {
        return view('emploi-du-temps.show', compact('emploiDuTemp'));
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(EmploiDuTemps $emploiDuTemp)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('emploi-du-temps.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de modifier des emplois du temps.');
        }
        
        $formations = Formation::all();
        $salles = Salle::all();
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        
        return view('emploi-du-temps.edit', compact('emploiDuTemp', 'formations', 'salles', 'jours'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, EmploiDuTemps $emploiDuTemp)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('emploi-du-temps.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de modifier des emplois du temps.');
        }
        
        $validated = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'salle_id' => 'required|exists:salles,id',
            'jour' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'est_actif' => 'boolean',
        ]);
        
        
        $isAvailable = EmploiDuTemps::isSalleAvailable(
            $validated['salle_id'],
            $validated['jour'],
            $validated['heure_debut'],
            $validated['heure_fin'],
            $emploiDuTemp->id
        );
        
        if (!$isAvailable) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La salle n\'est pas disponible à cette heure.');
        }
        
        
        $formation = Formation::findOrFail($validated['formation_id']);
        $formateurId = $formation->formateur_id;
        
        $formateurOccupe = EmploiDuTemps::whereHas('formation', function ($query) use ($formateurId) {
                $query->where('formateur_id', $formateurId);
            })
            ->where('id', '!=', $emploiDuTemp->id)
            ->where('jour', $validated['jour'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('heure_debut', '<', $validated['heure_fin'])
                      ->where('heure_fin', '>', $validated['heure_debut']);
                });
            })
            ->exists();
            
        if ($formateurOccupe) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Le formateur n\'est pas disponible à cette heure.');
        }
        
        $emploiDuTemp->update($validated);
        
        return redirect()->route('emploi-du-temps.index')
            ->with('success', 'Emploi du temps mis à jour avec succès.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(EmploiDuTemps $emploiDuTemp)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('emploi-du-temps.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de supprimer des emplois du temps.');
        }
        
        $emploiDuTemp->delete();
        
        return redirect()->route('emploi-du-temps.index')
            ->with('success', 'Emploi du temps supprimé avec succès.');
    }

    /**
     * Display the schedule for a specific formateur.
     */
    public function formateurSchedule(Formateur $formateur)
    {
        $emploiDuTemps = EmploiDuTemps::whereHas('formation', function ($query) use ($formateur) {
                $query->where('formateur_id', $formateur->id);
            })
            ->with(['formation', 'salle'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();
            
        return view('emploi-du-temps.formateur', compact('formateur', 'emploiDuTemps'));
    }

    /**
     * Display the schedule for a specific formation.
     */
    public function formationSchedule(Formation $formation)
    {
        $emploiDuTemps = EmploiDuTemps::where('formation_id', $formation->id)
            ->with(['salle'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();
            
        return view('emploi-du-temps.formation', compact('formation', 'emploiDuTemps'));
    }
}
