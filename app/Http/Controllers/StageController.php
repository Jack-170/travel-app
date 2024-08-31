<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    // Metodo per visualizzare il modulo di creazione
    public function create(Day $day)
    {
        // Verifica che l'utente loggato sia il proprietario del viaggio associato a questo giorno
        if ($day->trip->user_id !== Auth::id()) {
            abort(403, 'Non sei autorizzato a creare tappe per questo viaggio.');
        }

        $apiKey = config('services.opencage.key'); // Recupera la chiave API dalle configurazioni
        return view('stages.create', compact('day', 'apiKey'));
    }

    // Metodo per salvare una nuova tappa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:100',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Limite di 2 MB
            'day_id' => 'required|exists:days,id',
        ]);

        // Se l'immagine è stata caricata, salva il file e memorizza il percorso
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('stages', 'public');
        }

        // Aggiungi lo slug
        $validated['slug'] = \Str::slug($validated['title']);

        // Crea lo stage
        Stage::create($validated);

        return redirect()->route('days.show', $validated['day_id'])->with('success', 'Tappa creata con successo!');
    }


    // Metodo per visualizzare i dettagli di una tappa
    public function show($id)
    {
        $stage = Stage::findOrFail($id);

        // Verifica che l'utente loggato sia il proprietario del viaggio associato a questa tappa
        if ($stage->day->trip->user_id !== Auth::id()) {
            abort(403, 'Non sei autorizzato a visualizzare questa tappa.');
        }

        $apiKey = config('services.opencage.key'); // Supponendo che la tua chiave API sia salvata nei file di configurazione

        return view('stages.show', compact('stage', 'apiKey'));
    }

    // Metodo per visualizzare il modulo di modifica
    public function edit(Stage $stage)
    {
        // Verifica che l'utente loggato sia il proprietario del viaggio associato a questa tappa
        if ($stage->day->trip->user_id !== Auth::id()) {
            abort(403, 'Non sei autorizzato a modificare questa tappa.');
        }

        $apiKey = config('services.opencage.key'); // Recupera la chiave API dalle configurazioni
        return view('stages.edit', compact('stage', 'apiKey'));
    }

    // Metodo per aggiornare una tappa
    public function update(Request $request, Stage $stage)
    {
        // Verifica che l'utente loggato sia il proprietario del viaggio associato a questa tappa
        if ($stage->day->trip->user_id !== Auth::id()) {
            abort(403, 'Non sei autorizzato ad aggiornare questa tappa.');
        }
        $validated = $request->validate([
            'title' => 'required|min:3|max:100',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Limite di 2 MB
            'day_id' => 'required|exists:days,id',
        ]);

        // Se è stata caricata una nuova immagine, sostituisci la precedente
        if ($request->hasFile('image')) {
            // Elimina l'immagine precedente se esiste
            if ($stage->image) {
                Storage::delete($stage->image);
            }
            $validated['image'] = $request->file('image')->store('stages', 'public');
        }

        // Aggiorna lo stage con i nuovi dati
        $stage->update($validated);

        return redirect()->route('stages.show', $stage->id)->with('success', 'Tappa aggiornata con successo!');
    }


    // Metodo per eliminare una tappa
    public function destroy(Stage $stage)
    {
        // Verifica che l'utente loggato sia il proprietario del viaggio associato a questa tappa
        if ($stage->day->trip->user_id !== Auth::id()) {
            abort(403, 'Non sei autorizzato ad eliminare questa tappa.');
        }

        if ($stage->image) {
            Storage::delete($stage->image);
        }

        $dayId = $stage->day_id;
        $stage->delete();

        return redirect()->route('days.show', $dayId)->with('success', 'Tappa eliminata con successo!');
    }

    // Metodo per aggiornare lo stato di completamento di una tappa
    public function updateCompletion(Request $request, Stage $stage)
    {
        // Verifica che l'utente loggato sia il proprietario del viaggio associato a questa tappa
        if ($stage->day->trip->user_id !== Auth::id()) {
            abort(403, 'Non sei autorizzato ad aggiornare lo stato di completamento di questa tappa.');
        }

        $stage->completed = $request->has('completed');
        $stage->save();

        return redirect()->back();
    }
}
