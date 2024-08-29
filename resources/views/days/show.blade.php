<!-- resources/views/days/show.blade.php -->
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
        <ul>
            @foreach($day->stages as $stage)
                <li>{{ $stage->title }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Link per tornare indietro alla vista del viaggio -->
    <a href="{{ route('trips.show', $day->trip_id) }}" class="btn btn-primary">Torna al viaggio</a>
@endsection
