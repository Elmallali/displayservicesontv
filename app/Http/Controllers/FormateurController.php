<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use Illuminate\Http\Request;

class FormateurController extends Controller
{
    
    public function index()
    {
        $formateurs = Formateur::latest()->get();
        return view('formateurs.index', compact('formateurs'));
    }

    
    public function create()
    {
        return view('formateurs.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'specialite' => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
        ]);

        Formateur::create($request->all());

        return redirect()->route('formateurs.index')->with('success', 'Formateur ajouté avec succès.');
    }

    
    public function show(Formateur $formateur)
    {
        return view('formateurs.show', compact('formateur'));
    }

    
    public function edit(Formateur $formateur)
    {
        return view('formateurs.edit', compact('formateur'));
    }

    
    public function update(Request $request, Formateur $formateur)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'specialite' => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
        ]);

        $formateur->update($request->all());

        return redirect()->route('formateurs.index')->with('success', 'Formateur mis à jour.');
    }

    
    public function destroy(Formateur $formateur)
    {
        $formateur->delete();
        return redirect()->route('formateurs.index')->with('success', 'Formateur supprimé.');
    }
}

