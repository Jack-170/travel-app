<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function days()
    {
        return $this->hasMany(Day::class);
    }


    protected $fillable = ['title', 'slug', 'destination', 'leaving', 'return'];
}
