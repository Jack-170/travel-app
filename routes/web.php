<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

// Pagina home
Route::get('/', function () {
    return view('home');
})->name('home');

// Rotte per i trips
Route::middleware('auth')->group(function () {
    // Visualizzare la lista di tutti i trips (index)
    Route::get('/trips/index', [TripController::class, 'index'])->name('trips.index');

    // Visualizzare il form di creazione di un nuovo trip (create)
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');

    // Salvare un nuovo trip nel database (store)
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');

    // Visualizzare un singolo trip (show)
    Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

    // Visualizzare il form di modifica di un trip esistente (edit)
    Route::get('/trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');

    // Aggiornare un trip esistente nel database (update)
    Route::put('/trips/{trip}', [TripController::class, 'update'])->name('trips.update');

    // Eliminare un trip dal database (destroy)
    Route::delete('/trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');
});

// Pagina dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotte per il profilo utente
Route::middleware('auth')->group(function () {
    // Visualizzare il profilo utente (edit)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Aggiornare il profilo utente
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Eliminare il profilo utente
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
