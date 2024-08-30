@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4 custom-main-color">Modifica Viaggio</h1>

        <form method="POST" action="{{ route('trips.update', $trip->id) }}">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label custom-main-color">Titolo</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $trip->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Destination -->
            <div class="mb-3">
                <label for="destination" class="form-label  custom-main-color">Destinazione</label>
                <input type="text" class="form-control @error('destination') is-invalid @enderror" id="destination" name="destination" value="{{ old('destination', $trip->destination) }}" required>
                @error('destination')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Leaving Date -->
            <div class="mb-3">
                <label for="leaving" class="form-label custom-main-color">Data di Partenza</label>
                <input type="date" class="form-control @error('leaving') is-invalid @enderror" id="leaving" name="leaving" value="{{ old('leaving', $trip->leaving) }}" required>
                @error('leaving')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Return Date -->
            <div class="mb-3">
                <label for="return" class="form-label custom-main-color">Data di Ritorno</label>
                <input type="date" class="form-control @error('return') is-invalid @enderror" id="return" name="return" value="{{ old('return', $trip->return) }}" required>
                @error('return')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('trips.index') }}" class="btn custom-main-color me-2">Annulla</a>
                <button type="submit" class="btn custom-main-color">Salva Modifiche</button>
            </div>
        </form>
    </div>
@endsection
