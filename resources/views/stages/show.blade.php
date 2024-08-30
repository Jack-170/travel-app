@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>{{ $stage->title }}</h1>

        @if($stage->image)
            <div class="mb-3">
                <img src="{{ Storage::url($stage->image) }}" alt="{{ $stage->title }}" class="img-fluid">
            </div>
        @endif

        <div class="mb-3">
            <h2>Descrizione</h2>
            <p>{{ $stage->description }}</p>
        </div>

        <div class="mb-3">
            <h2>Localizzazione</h2>
            <p><strong></strong> {{ $stage->location}}</p>
        </div>

        <!-- Pulsante per tornare alla vista del giorno -->
        <a href="{{ route('days.show', $stage->day_id) }}" class="btn btn-primary">Torna al giorno</a>

        <!-- Pulsante per tornare alla vista del viaggio -->
        <a href="{{ route('trips.show', $stage->day->trip_id) }}" class="btn btn-primary">Torna al viaggio</a>

        <!-- Pulsante per modificare la tappa -->
        <a href="{{ route('stages.edit', $stage->id) }}" class="btn btn-warning">Modifica Tappa</a>

        <!-- Pulsante per eliminare la tappa -->
        <form action="{{ route('stages.destroy', $stage->id) }}" method="POST" class="mt-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Elimina Tappa</button>
        </form>
    </div>
@endsection
