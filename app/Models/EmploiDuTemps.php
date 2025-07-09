<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'emploi_du_temps';

    protected $fillable = [
        'formation_id',
        'salle_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'date_debut',
        'date_fin',
        'est_actif',
    ];

    protected $casts = [
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'est_actif' => 'boolean',
    ];

    /**
     * Get the formation associated with this schedule.
     */
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    /**
     * Get the classroom (salle) associated with this schedule.
     */
    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    /**
     * Check if the classroom is available at the specified time.
     */
    public static function isSalleAvailable($salleId, $jour, $heureDebut, $heureFin, $excludeId = null)
    {
        $query = self::where('salle_id', $salleId)
            ->where('jour', $jour)
            ->where('est_actif', true)
            ->where(function ($query) use ($heureDebut, $heureFin) {
                
                $query->where(function ($q) use ($heureDebut, $heureFin) {
                    $q->where('heure_debut', '<', $heureFin)
                      ->where('heure_fin', '>', $heureDebut);
                });
            });
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->count() === 0;
    }

    /**
     * Get the current active schedule entries.
     */
    public static function getActiveSchedules()
    {
        $today = Carbon::now();
        
        return self::where('est_actif', true)
            ->where(function ($query) use ($today) {
                $query->where('date_fin', '>=', $today)
                      ->orWhereNull('date_fin');
            })
            ->where('date_debut', '<=', $today)
            ->get();
    }

    /**
     * Get the current schedule for a specific day.
     */
    public static function getScheduleForDay($jour)
    {
        $today = Carbon::now();
        
        return self::where('est_actif', true)
            ->where('jour', $jour)
            ->where(function ($query) use ($today) {
                $query->where('date_fin', '>=', $today)
                      ->orWhereNull('date_fin');
            })
            ->where('date_debut', '<=', $today)
            ->orderBy('heure_debut')
            ->get();
    }

    /**
     * Get the formatted time range.
     */
    public function getTimeRangeAttribute()
    {
        return Carbon::parse($this->heure_debut)->format('H:i') . ' - ' . 
               Carbon::parse($this->heure_fin)->format('H:i');
    }
}
