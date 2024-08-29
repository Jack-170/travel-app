@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">{{ $trip->title }}</h1>
            <p><strong>Destinazione:</strong> {{ $trip->destination }}</p>
            <p><strong>Data di Partenza:</strong> {{ \Carbon\Carbon::parse($trip->leaving)->format('d M Y') }}</p>
            <p><strong>Data di Ritorno:</strong> {{ \Carbon\Carbon::parse($trip->return)->format('d M Y') }}</p>

            <hr>

            <h2 class="mt-4">Giorni del Viaggio</h2>
            <ul class="list-group">
                @foreach ($trip->days->sortBy('date') as $day)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $day->date }}
                        <a href="{{ route('days.show', $day->id) }}" class="btn custom-main-color">Dettagli</a>
                    </li>
                @endforeach
            </ul>

            <hr>

            <a href="{{ route('trips.index') }}" class="btn btn-secondary">Torna ai Viaggi</a>
            <a href="{{ route('trips.edit', $trip->id) }}" class="btn btn-primary">Modifica Viaggio</a>

            <!-- Delete button with confirmation -->
            <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questo viaggio?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Elimina Viaggio</button>
            </form>
        </div>
    </div>
</div>
@endsection
