<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'slug', 'location', 'description', 'image', 'completed', 'day_id'];

       public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
