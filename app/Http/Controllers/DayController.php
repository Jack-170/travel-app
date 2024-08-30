<?php

namespace App\Http\Controllers;

use App\Models\Day;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DayController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $day = Day::findOrFail($id);
        $day->load('stages');
        return view('days.show', compact('day'));
    }
}
