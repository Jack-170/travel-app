<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StageController extends Controller
{
    public function create(Day $day)
    {
        return view('stages.create', compact('day'));
    }

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
            $validated['image'] = $request->file('image')->store('stages');
        }

        $validated['slug'] = Str::slug($validated['title']);

        Stage::create($validated);

        return redirect()->route('days.show', $validated['day_id'])->with('success', 'Tappa creata con successo!');
    }

    public function show(Stage $stage)
    {
        return view('stages.show', compact('stage'));
    }

    public function edit(Stage $stage)
    {
        $locationParts = explode('|', $stage->location);
        $stage->location = $locationParts[0];
        $stage->latitude = $locationParts[1];
        $stage->longitude = $locationParts[2];

        return view('stages.edit', compact('stage'));
    }

    public function update(Request $request, Stage $stage)
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
            if ($stage->image) {
                Storage::delete($stage->image);
            }

            $validated['image'] = $request->file('image')->store('stages');
        }

        $validated['slug'] = Str::slug($validated['title']);

        $stage->update($validated);

        return redirect()->route('days.show', $validated['day_id'])->with('success', 'Tappa aggiornata con successo!');
    }

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
