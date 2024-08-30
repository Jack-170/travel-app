@extends('layouts.main')

@section('content')
    <h1>Dettagli del giorno: {{ $day->date }}</h1>

    <p><strong>Data:</strong> {{ $day->date }}</p>

    <!-- Pulsante per creare una nuova tappa -->
    <a href="{{ route('stages.create', ['day' => $day->id]) }}" class="btn btn-primary mb-4">Aggiungi Nuova Tappa</a>

    <h2>Tappe</h2>
    @if($day->stages->isEmpty())
        <p>No tappe presenti.</p>
    @else
        <ul class="list-group">
            @foreach($day->stages as $index => $stage)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <!-- Numerazione delle tappe -->
                    <span>{{ $loop->iteration }}. {{ $stage->title }}</span>

                    <!-- Pulsante accanto alla tappa -->
                    <div>
                        <!-- Esempio di pulsante, potresti cambiare l'azione -->
                        <a href="{{ route('stages.show', $stage->id) }}" class="btn btn-info btn-sm">Dettagli</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Link per tornare indietro alla vista del viaggio -->
    <a href="{{ route('trips.show', $day->trip_id) }}" class="btn btn-primary mt-4">Torna al viaggio</a>
@endsection
