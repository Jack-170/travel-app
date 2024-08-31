@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row align-items-center">
        <!-- Titolo del giorno -->
        <div class="col-md-9 my-2">
            <h1 class="custom-main-color">Dettagli del giorno:</h1>
        </div>
        <!-- Pulsante per aggiungere una tappa -->
        <div class="col-md-3 text-end">
            <a href="{{ route('stages.create', ['day' => $day->id]) }}" class="btn custom-main-color">Aggiungi Nuova Tappa</a>
        </div>
    </div>


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

                    <!-- Switch per completamento -->
                    <form action="{{ route('stages.updateCompletion', $stage) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="stageSwitch{{ $stage->id }}"
                                name="completed"
                                {{ $stage->completed ? 'checked' : '' }}
                                onchange="this.form.submit()"
                            >
                            <label class="form-check-label" for="stageSwitch{{ $stage->id }}">
                                {{ $stage->completed ? 'Tappa Completata' : 'Tappa Non Completata' }}
                            </label>
                        </div>
                    </form>

                    <!-- Pulsante accanto alla tappa -->
                    <div>

                        <a href="{{ route('stages.show', $stage->id) }}" class="btn custom-main-color btn-sm">Dettagli</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Link per tornare indietro alla vista del viaggio -->
    <a href="{{ route('trips.show', ['trip' => $day->trip_id, 'title' => Str::slug($day->trip->title)]) }}" class="btn custom-main-color mt-4">Torna al viaggio</a>
</div>
@endsection
