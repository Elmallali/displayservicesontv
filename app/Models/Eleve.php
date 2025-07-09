<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'telephone',
        'email',
        'langue_suivie',
    ];
    
    /**
     * Get all paiements made by this eleve.
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
    
    /**
     * Get all formations this eleve is enrolled in.
     */
    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'eleve_formation')
            ->withPivot('date_inscription', 'statut')
            ->withTimestamps();
    }
    
    /**
     * Get active formations for this eleve.
     */
    public function formationsActives()
    {
        return $this->belongsToMany(Formation::class, 'eleve_formation')
            ->wherePivot('statut', 'actif')
            ->withPivot('date_inscription', 'statut')
            ->withTimestamps();
    }
    
    /**
     * Check if the eleve has paid for a specific formation for the current month.
     */
    public function aPayePourMoisCourant(Formation $formation)
    {
        $moisCourant = now()->format('F Y'); 
        
        return $this->paiements()
            ->where('formation_id', $formation->id)
            ->where('mois', $moisCourant)
            ->where('est_confirme', true)
            ->exists();
    }
}
