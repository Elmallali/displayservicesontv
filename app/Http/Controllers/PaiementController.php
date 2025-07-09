<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Eleve;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
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
     * Display a listing of the payments with optional filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Paiement::with(['eleve', 'formation'])->latest();
        
        
        if ($request->has('mois') && !empty($request->mois)) {
            $query->where('mois', 'like', '%' . $request->mois . '%');
        }
        
        if ($request->has('eleve_id') && !empty($request->eleve_id)) {
            $query->where('eleve_id', $request->eleve_id);
        }
        
        if ($request->has('formation_id') && !empty($request->formation_id)) {
            $query->where('formation_id', $request->formation_id);
        }
        
        if ($request->has('est_confirme') && $request->est_confirme !== '') {
            $query->where('est_confirme', $request->est_confirme);
        }
        
        $paiements = $query->get();
        
        return view('paiements.index', compact('paiements'));
    }

    
    public function create()
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('paiements.index')
                ->with('error', 'Vous n\'avez pas la permission de créer des paiements.');
        }
        
        $eleves = Eleve::all();
        $formations = Formation::all();
        return view('paiements.create', compact('eleves', 'formations'));
    }

    
    public function store(Request $request)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('paiements.index')
                ->with('error', 'Vous n\'avez pas la permission de créer des paiements.');
        }
        
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'formation_id' => 'required|exists:formations,id',
            'mois' => 'required|string',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'methode' => 'nullable|string',
            'est_confirme' => 'boolean',
            'commentaire' => 'nullable|string',
        ]);

        
        $eleve = Eleve::findOrFail($request->eleve_id);
        $formation = Formation::findOrFail($request->formation_id);
        
        if (!$eleve->formations()->where('formation_id', $formation->id)->exists()) {
            return redirect()->back()
                ->with('error', 'L\'élève n\'est pas inscrit à cette formation.')
                ->withInput();
        }

        
        $paiement = new Paiement($request->all());
        $paiement->est_confirme = $request->has('est_confirme');
        $paiement->save();

        return redirect()->route('paiements.index')->with('success', 'Paiement ajouté avec succès.');
    }

    
    public function show(Paiement $paiement)
    {
        return view('paiements.show', compact('paiement'));
    }

    
    public function edit(Paiement $paiement)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('paiements.index')
                ->with('error', 'Vous n\'avez pas la permission de modifier des paiements.');
        }
        
        $eleves = Eleve::all();
        $formations = Formation::all();
        return view('paiements.edit', compact('paiement', 'eleves', 'formations'));
    }

    
    public function update(Request $request, Paiement $paiement)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('paiements.index')
                ->with('error', 'Vous n\'avez pas la permission de modifier des paiements.');
        }
        
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'formation_id' => 'required|exists:formations,id',
            'mois' => 'required|string',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'methode' => 'nullable|string',
            'commentaire' => 'nullable|string',
        ]);

        
        $eleve = Eleve::findOrFail($request->eleve_id);
        $formation = Formation::findOrFail($request->formation_id);
        
        if (!$eleve->formations()->where('formation_id', $formation->id)->exists()) {
            return redirect()->back()
                ->with('error', 'L\'élève n\'est pas inscrit à cette formation.')
                ->withInput();
        }

        
        $paiement->fill($request->except('est_confirme'));
        $paiement->est_confirme = $request->has('est_confirme');
        $paiement->save();

        return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour.');
    }

    
    public function destroy(Paiement $paiement)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('paiements.index')
                ->with('error', 'Vous n\'avez pas la permission de supprimer des paiements.');
        }
        
        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé.');
    }
    
    /**
     * Toggle the confirmation status of a payment.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function toggleConfirmation(Paiement $paiement)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('paiements.index')
                ->with('error', 'Vous n\'avez pas la permission de confirmer des paiements.');
        }
        
        $paiement->est_confirme = !$paiement->est_confirme;
        $paiement->save();
        
        $status = $paiement->est_confirme ? 'confirmé' : 'non confirmé';
        return redirect()->back()->with('success', "Le paiement a été marqué comme {$status}.");
    }
    
    /**
     * Display payments for a specific student.
     *
     * @param  \App\Models\Eleve  $eleve
     * @return \Illuminate\Http\Response
     */
    public function elevePaiements(Eleve $eleve)
    {
        
        $eleve->load(['formations.formateur', 'paiements.formation']);
        
        
        $paiements = $eleve->paiements()->with('formation')->latest()->get();
        
        return view('paiements.eleve', compact('eleve', 'paiements'));
    }
    
    /**
     * Display payments for a specific formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function formationPaiements(Formation $formation, Request $request)
    {
        
        $formation->load('formateur');
        
        
        $paymentsQuery = $formation->paiements()->with('eleve');
        
        
        if ($request->has('mois') && !empty($request->mois)) {
            $paymentsQuery->where('mois', $request->mois);
        }
        
        
        $paiements = $paymentsQuery->latest()->get();
        
        
        $moisDisponibles = $formation->paiements()
            ->select('mois')
            ->distinct()
            ->pluck('mois')
            ->toArray();
        
        
        $totalPaiements = $paiements->count();
        $paiementsConfirmes = $paiements->where('est_confirme', true)->count();
        $paiementsNonConfirmes = $paiements->where('est_confirme', false)->count();
        $montantTotal = $paiements->sum('montant');
        
        return view('paiements.formation', compact(
            'formation', 
            'paiements', 
            'moisDisponibles', 
            'totalPaiements', 
            'paiementsConfirmes', 
            'paiementsNonConfirmes', 
            'montantTotal'
        ));
    }
}
