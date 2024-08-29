<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    // Se la tabella non segue la convenzione plurale di Laravel, specifica il nome della tabella
    // protected $table = 'days';

    // Indica quali attributi sono assegnabili in massa
    protected $fillable = ['date', 'trip_id'];

    // Definisce la relazione con il modello Trip
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // Definisce la relazione con il modello Stage
    public function stages()
    {
        return $this->hasMany(Stage::class);
    }
}
