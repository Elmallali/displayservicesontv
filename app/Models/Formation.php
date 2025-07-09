<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'niveau',
        'niveau_langue', 
        'prix_mensuel',
        'duree_mois',
        'formateur_id',
        'langue', 
        'places_disponibles',
        'places_maximum',
    ];

    /**
     * The language levels available
     */
    public static $niveauxLangue = [
        'A1' => 'Débutant',
        'A2' => 'Élémentaire',
        'B1' => 'Intermédiaire',
        'B2' => 'Intermédiaire supérieur',
        'C1' => 'Avancé',
        'C2' => 'Maîtrise'
    ];

    /**
     * Get the formateur that teaches this formation.
     */
    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    /**
     * Get the eleves enrolled in this formation.
     */
    public function eleves()
    {
        return $this->belongsToMany(Eleve::class, 'eleve_formation')
            ->withPivot('date_inscription', 'statut')
            ->withTimestamps();
    }

    /**
     * Get the paiements associated with this formation.
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Get the schedule entries for this formation.
     */
    public function emploiDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    /**
     * Get active eleves for this formation.
     */
    public function elevesActifs()
    {
        return $this->belongsToMany(Eleve::class, 'eleve_formation')
            ->wherePivot('statut', 'actif')
            ->withPivot('date_inscription', 'statut')
            ->withTimestamps();
    }

    /**
     * Get eleves who have paid for the current month.
     */
    public function elevesPayesPourMoisCourant()
    {
        $moisCourant = Carbon::now()->format('F Y');
        
        return $this->eleves()
            ->whereHas('paiements', function ($query) use ($moisCourant) {
                $query->where('formation_id', $this->id)
                      ->where('mois', $moisCourant)
                      ->where('est_confirme', true);
            });
    }

    /**
     * Get eleves who have not paid for the current month.
     */
    public function elevesNonPayesPourMoisCourant()
    {
        $moisCourant = Carbon::now()->format('F Y');
        
        return $this->elevesActifs()
            ->whereDoesntHave('paiements', function ($query) use ($moisCourant) {
                $query->where('formation_id', $this->id)
                      ->where('mois', $moisCourant)
                      ->where('est_confirme', true);
            });
    }

    /**
     * Check if the formation has available places.
     */
    public function hasPlacesDisponibles()
    {
        return $this->places_disponibles > 0;
    }

    /**
     * Update available places when a student enrolls or unenrolls.
     */
    public function updatePlacesDisponibles()
    {
        $this->places_disponibles = $this->places_maximum - $this->elevesActifs()->count();
        $this->save();
    }
}
