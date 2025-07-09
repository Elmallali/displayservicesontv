<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Salle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'etage',
        'capacite',
        'description',
        'est_disponible',
    ];

    protected $casts = [
        'est_disponible' => 'boolean',
    ];

    /**
     * Get the schedule entries for this classroom.
     */
    public function emploiDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    /**
     * Check if the classroom is available at a specific time.
     */
    public function isAvailableAt($jour, $heureDebut, $heureFin)
    {
        if (!$this->est_disponible) {
            return false;
        }

        return EmploiDuTemps::isSalleAvailable($this->id, $jour, $heureDebut, $heureFin);
    }

    /**
     * Get all formations scheduled in this classroom for today.
     */
    public function formationsAujourdhui()
    {
        $jourActuel = strtolower(Carbon::now()->locale('fr')->dayName);
        
        return Formation::whereHas('emploiDuTemps', function ($query) use ($jourActuel) {
            $query->where('salle_id', $this->id)
                  ->where('jour', $jourActuel)
                  ->where('est_actif', true);
        })->get();
    }

    /**
     * Get the current or next scheduled formation in this classroom.
     */
    public function formationActuelle()
    {
        $maintenant = Carbon::now();
        $jourActuel = strtolower($maintenant->locale('fr')->dayName);
        $heureActuelle = $maintenant->format('H:i:s');
        
        $emploi = $this->emploiDuTemps()
            ->where('jour', $jourActuel)
            ->where('est_actif', true)
            ->where('heure_debut', '<=', $heureActuelle)
            ->where('heure_fin', '>=', $heureActuelle)
            ->first();
            
        if ($emploi) {
            return $emploi->formation;
        }
        
        return null;
    }

    /**
     * Get the next scheduled formation in this classroom.
     */
    public function prochainFormation()
    {
        $maintenant = Carbon::now();
        $jourActuel = strtolower($maintenant->locale('fr')->dayName);
        $heureActuelle = $maintenant->format('H:i:s');
        
        $emploi = $this->emploiDuTemps()
            ->where('jour', $jourActuel)
            ->where('est_actif', true)
            ->where('heure_debut', '>', $heureActuelle)
            ->orderBy('heure_debut')
            ->first();
            
        if ($emploi) {
            return $emploi->formation;
        }
        
        return null;
    }
}
