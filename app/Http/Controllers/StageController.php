<?php
namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StageController extends Controller
{
    // Metodo per visualizzare il modulo di creazione
    public function create(Day $day)
    {
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'day_id' => 'required|exists:days,id',
    ]);

    $validated['location'] = "{$validated['location']}|{$validated['latitude']}|{$validated['longitude']}";

    if ($request->hasFile('image')) {
        // Memorizza l'immagine e ottieni il percorso relativo
        $validated['image'] = $request->file('image')->store('stages', 'public');
    }

    $validated['slug'] = Str::slug($validated['title']);

    Stage::create($validated);

    return redirect()->route('days.show', $validated['day_id'])->with('success', 'Tappa creata con successo!');
}


    // Metodo per visualizzare i dettagli di una tappa
    public function show(Stage $stage)
    {
        return view('stages.show', compact('stage'));
    }

    // Metodo per visualizzare il modulo di modifica
    public function edit(Stage $stage)
    {
        $apiKey = config('services.opencage.key'); // Recupera la chiave API dalle configurazioni
        return view('stages.edit', compact('stage', 'apiKey'));
    }

    // Metodo per aggiornare una tappa
    public function update(Request $request, Stage $stage)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:100',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'day_id' => 'required|exists:days,id',
        ]);

        if ($request->hasFile('image')) {
            if ($stage->image) {
                Storage::delete($stage->image);
            }
            $validated['image'] = $request->file('image')->store('stages');
        }

        $stage->update($validated);

        return redirect()->route('stages.show', $stage->id)->with('success', 'Tappa aggiornata con successo!');
    }

    // Metodo per eliminare una tappa
    public function destroy(Stage $stage)
    {
        if ($stage->image) {
            Storage::delete($stage->image);
        }

        $dayId = $stage->day_id;
        $stage->delete();

        return redirect()->route('days.show', $dayId)->with('success', 'Tappa eliminata con successo!');
    }
}
