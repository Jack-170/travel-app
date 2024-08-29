<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::all();
        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $form_data = $request->all();

        $val_data = $request->validate(
            [
                'title' => 'required|min:3|max:100',
                'destination' => 'required|min:3|max:100',
                'leaving' => ['required', function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime(date('Y-m-d'))) {
                        $fail('La data di partenza deve essere uguale o successiva alla data odierna.');
                    }
                }],
                'return' => ['required', function ($attribute, $value, $fail) use ($request) {
                    if (strtotime($value) < strtotime($request->leaving)) {
                        $fail('La data di ritorno deve essere uguale o successiva alla data di partenza.');
                    }
                }],
            ],
            [
                'title.required' => 'Il campo Titolo è obbligatorio',
                'title.min' => 'Il campo Titolo deve contenere almeno :min caratteri',
                'title.max' => 'Il campo Titolo non può contenere più di :max caratteri',
                'destination.required' => 'Il campo Destinazione è obbligatorio',
                'destination.min' => 'Il campo Destinazione deve contenere almeno :min caratteri',
                'destination.max' => 'Il campo Destinazione non può contenere più di :max caratteri',
                'leaving.required' => 'Il campo Partenza è obbligatorio',
                'return.required' => 'Il campo Ritorno è obbligatorio'
            ]
        );

        // Creazione dello slug (puoi implementare una funzione simile nel tuo Helper)
        $form_data['slug'] = \Str::slug($form_data['title']);

        // Creazione del nuovo viaggio (trip)
        $newTrip = new Trip();
        $newTrip->user_id = Auth::user()->id;
        $newTrip->fill($form_data);
        $newTrip->save();

        // Creazione dei giorni per il viaggio
        $trip_start = Carbon::parse($newTrip['leaving']);
        $trip_end = Carbon::parse($newTrip['return']);
        $trip_length = $trip_end->diffInDays($trip_start) + 1;

        for ($i = 0; $i < $trip_length; $i++) {
            $date = $trip_start->copy()->addDays($i);

            $newDay = new Day();
            $newDay->trip_id = $newTrip->id;
            $newDay->date = $date->format('Y-m-d');
            $newDay->save();
        }

        return redirect()->route('trips.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trip = Trip::findOrFail($id);
        return view('trips.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        $form_data = $request->all();

        $val_data = $request->validate(
            [
                'title' => 'required|min:3|max:100',
                'destination' => 'required|min:3|max:100',
                'leaving' => ['required', function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime(date('Y-m-d'))) {
                        $fail('La data di partenza deve essere uguale o successiva alla data odierna.');
                    }
                }],
                'return' => ['required', function ($attribute, $value, $fail) use ($request) {
                    if (strtotime($value) < strtotime($request->leaving)) {
                        $fail('La data di ritorno deve essere uguale o successiva alla data di partenza.');
                    }
                }],
            ],
            [
                'title.required' => 'Il campo Titolo è obbligatorio',
                'title.min' => 'Il campo Titolo deve contenere almeno :min caratteri',
                'title.max' => 'Il campo Titolo non può contenere più di :max caratteri',
                'destination.required' => 'Il campo Destinazione è obbligatorio',
                'destination.min' => 'Il campo Destinazione deve contenere almeno :min caratteri',
                'destination.max' => 'Il campo Destinazione non può contenere più di :max caratteri',
                'leaving.required' => 'Il campo Partenza è obbligatorio',
                'return.required' => 'Il campo Ritorno è obbligatorio'
            ]
        );

        if ($form_data['title'] !== $trip->title) {
            $form_data['slug'] = \Str::slug($form_data['title']);
        }

        $trip->update($form_data);

        // Gestione dei giorni (days)
        $trip_start = Carbon::parse($form_data['leaving']);
        $trip_end = Carbon::parse($form_data['return']);
        $trip_length = $trip_end->diffInDays($trip_start) + 1;

        // Recupera le date già presenti nel DB per questo trip
        $existingDays = Day::where('trip_id', $trip->id)->get()->pluck('date')->toArray();

        // Rimuove i giorni che non rientrano più nel nuovo intervallo
        foreach ($existingDays as $existingDay) {
            if ($existingDay < $form_data['leaving'] || $existingDay > $form_data['return']) {
                $day = Day::where('trip_id', $trip->id)->where('date', $existingDay)->first();
                if ($day) {
                    $day->stages()->delete(); // Elimina gli stages associati
                    $day->delete(); // Elimina il giorno
                }
            }
        }

        // Aggiunge i nuovi giorni che rientrano nel nuovo intervallo
        for ($i = 0; $i < $trip_length; $i++) {
            $date = $trip_start->copy()->addDays($i)->format('Y-m-d');
            if (!in_array($date, $existingDays)) {
                $newDay = new Day();
                $newDay->trip_id = $trip->id;
                $newDay->date = $date;
                $newDay->save();
            }
        }

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $days = Day::where('trip_id', $trip->id)->get();

        foreach ($days as $day) {
            $day->stages()->delete();
            $day->delete();
        }

        $trip->delete();

        return redirect()->route('trips.index');
    }
}
