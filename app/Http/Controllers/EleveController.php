<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    
    public function index()
    {
        $eleves = Eleve::latest()->get();
        return view('eleves.index', compact('eleves'));
    }

    
    public function create()
    {
        
        $formations = \App\Models\Formation::where('places_disponibles', '>', 0)->get();
        return view('eleves.create', compact('formations'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required|in:homme,femme',
            'langue_suivie' => 'required',
            'formations' => 'sometimes|array',
            'formations.*' => 'exists:formations,id',
        ]);

        $eleve = Eleve::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'langue_suivie' => $request->langue_suivie,
        ]);

        
        if ($request->has('formations')) {
            foreach ($request->formations as $formationId) {
                $formation = \App\Models\Formation::find($formationId);
                if ($formation && $formation->places_disponibles > 0) {
                    $eleve->formations()->attach($formationId, [
                        'date_inscription' => now(),
                        'statut' => 'actif'
                    ]);
                    
                    
                    $formation->places_disponibles = $formation->places_disponibles - 1;
                    $formation->save();
                }
            }
        }

        return redirect()->route('eleves.index')->with('success', 'Élève ajouté avec succès');
    }

    
    public function show(Eleve $eleve)
    {
        
        $eleve->load(['formations', 'paiements']);
        
        return view('eleves.show', compact('eleve'));
    }

    
    public function edit(Eleve $eleve)
    {
        
        $formations = \App\Models\Formation::where('places_disponibles', '>', 0)
            ->orWhereHas('eleves', function($query) use ($eleve) {
                $query->where('eleves.id', $eleve->id);
            })
            ->get();
        
        
        $eleveFormations = $eleve->formations->pluck('id')->toArray();
        
        return view('eleves.edit', compact('eleve', 'formations', 'eleveFormations'));
    }

    
    public function update(Request $request, Eleve $eleve)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required|in:homme,femme',
            'langue_suivie' => 'required',
            'formations' => 'sometimes|array',
            'formations.*' => 'exists:formations,id',
        ]);

        $eleve->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'langue_suivie' => $request->langue_suivie,
        ]);

        
        if ($request->has('formations')) {
            
            $currentFormations = $eleve->formations->pluck('id')->toArray();
            
            
            $formationsToAdd = array_diff($request->formations, $currentFormations);
            
            
            $formationsToRemove = array_diff($currentFormations, $request->formations);
            
            
            foreach ($formationsToAdd as $formationId) {
                $formation = \App\Models\Formation::find($formationId);
                if ($formation && $formation->places_disponibles > 0) {
                    $eleve->formations()->attach($formationId, [
                        'date_inscription' => now(),
                        'statut' => 'actif'
                    ]);
                    
                    
                    $formation->places_disponibles = $formation->places_disponibles - 1;
                    $formation->save();
                }
            }
            
            
            foreach ($formationsToRemove as $formationId) {
                $formation = \App\Models\Formation::find($formationId);
                if ($formation) {
                    $eleve->formations()->detach($formationId);
                    
                    
                    $formation->places_disponibles = $formation->places_disponibles + 1;
                    $formation->save();
                }
            }
        } else {
            
            foreach ($eleve->formations as $formation) {
                $formation->places_disponibles = $formation->places_disponibles + 1;
                $formation->save();
            }
            $eleve->formations()->detach();
        }

        return redirect()->route('eleves.index')->with('success', 'Élève mis à jour');
    }

    
    public function destroy(Eleve $eleve)
    {
        $eleve->delete();
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé');
    }
}
