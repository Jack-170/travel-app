@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row align-items-center">
            <!-- Titolo del giorno -->
            <div class="col-md-9">
                <h1 class="custom-main-color">Dettagli del giorno:</h1>
            </div>
            <!-- Pulsante per aggiungere una tappa -->
            <div class="col-md-3 text-end">
                <a href="{{ route('stages.create', ['day' => $day->id]) }}" class="btn custom-main-color">Aggiungi Nuova Tappa</a>
            </div>
        </div>

        <!-- Dettaglio della data del giorno -->
        <p><strong>Data:</strong> {{ $day->date }}</p>

        <h2 class="custom-main-color">Tappe</h2>
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
                            <a href="{{ route('stages.show', $stage->id) }}" class="btn custom-main-color btn-sm">Dettagli</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Link per tornare indietro alla vista del viaggio -->
        <a href="{{ route('trips.show', $day->trip_id) }}" class="btn custom-main-color mt-4">Torna al viaggio</a>
    </div>
@endsection
