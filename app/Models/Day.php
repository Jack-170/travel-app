<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;


    protected $fillable = ['date', 'trip_id'];


    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

        public function stages()
    {
        return $this->hasMany(Stage::class);
    }
}
