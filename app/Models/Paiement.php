<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'formation_id',
        'mois',
        'montant',
        'date_paiement',
        'methode',
        'est_confirme',
        'commentaire',
    ];

    /**
     * Get the eleve that made this payment.
     */
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
    
    /**
     * Get the formation this payment is for.
     */
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
    
    /**
     * Scope a query to only include confirmed payments.
     */
    public function scopeConfirmes($query)
    {
        return $query->where('est_confirme', true);
    }
    
    /**
     * Scope a query to only include payments for the current month.
     */
    public function scopeMoisCourant($query)
    {
        $moisCourant = now()->format('F Y'); 
        return $query->where('mois', $moisCourant);
    }
}
