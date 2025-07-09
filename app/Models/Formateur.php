<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'specialite',
        'telephone',
    ];

    public function formations()
    {
        return $this->hasMany(Formation::class);
    }
}
