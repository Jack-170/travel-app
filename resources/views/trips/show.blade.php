@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4 custom-main-color">{{ $trip->title }}</h1>

            <p>
                <span class="custom-main-color"><strong>Destinazione:</strong></span> {{ $trip->destination }}
            </p>

            <p>
                <span class="custom-main-color"><strong>Data di Partenza:</strong></span> {{ \Carbon\Carbon::parse($trip->leaving)->locale('it')->translatedFormat('d F Y') }}
            </p>

            <p>
                <span class="custom-main-color"><strong>Data di Ritorno:</strong></span> {{ \Carbon\Carbon::parse($trip->return)->locale('it')->translatedFormat('d F Y') }}
            </p>

            <hr>

            <h2 class="mt-4 custom-main-color">Giorni del Viaggio</h2>
            <ul class="list-group">
                @foreach ($trip->days->sortBy('date') as $day)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ \Carbon\Carbon::parse($day->date)->locale('it')->translatedFormat('d F Y') }}
                        <a href="{{ route('days.show', $day->id) }}" class="btn custom-main-color">Dettagli</a>
                    </li>
                @endforeach
            </ul>

            <hr>

            <a href="{{ route('trips.index') }}" class="btn custom-main-color">Torna ai Viaggi</a>
            <a href="{{ route('trips.edit', $trip->id) }}" class="btn custom-main-color">Modifica Viaggio</a>

            <!-- Delete button with confirmation -->
            <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Sei sicuro di voler eliminare questo viaggio?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn custom-main-color">Elimina Viaggio</button>
            </form>
        </div>
    </div>
</div>
@endsection
