<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    // Definisci gli attributi assegnabili in massa
    protected $fillable = ['title', 'slug', 'location', 'description', 'image', 'day_id'];

    // Definisce la relazione con il modello Day
    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
