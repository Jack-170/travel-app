@extends('layouts.main')

@section('content')

    @if ($errors->any())
    <div class="alert alert-danger w-75 mx-auto mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form class="container mt-5" action="{{ route('trips.store') }}" method="post">
        @csrf
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <h3 class="text-center custom-main-color mb-4">Progettazione Viaggio</h3>

                <!-- Row for Input Fields -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label custom-main-color fs-5 fw-bold">Titolo <span class="text-danger">*</span></label>
                        <input value="{{ old('title') }}" name="title" id="title" type="text" class="form-control" aria-describedby="titleHelp">
                    </div>
                    <div class="col-md-6">
                        <label for="destination" class="form-label custom-main-color fs-5 fw-bold">Meta <span class="text-danger">*</span></label>
                        <input value="{{ old('destination') }}" name="destination" id="destination" type="text" class="form-control" aria-describedby="destinationHelp">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="leaving" class="form-label fs-5 custom-main-color fw-bold">Partenza <span class="text-danger">*</span></label>
                        <input value="{{ old('leaving') }}" name="leaving" id="leaving" type="date" class="form-control" aria-describedby="leavingHelp">
                    </div>
                    <div class="col-md-6">
                        <label for="return" class="form-label fs-5 custom-main-color fw-bold">Ritorno <span class="text-danger">*</span></label>
                        <input value="{{ old('return') }}" name="return" id="return" type="date" class="form-control" aria-describedby="returnHelp">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('home') }}" class="btn custom-main-color">Indietro</a>
                    <button type="submit" class="btn custom-main-color">Avanti</button>
                </div>
            </div>
        </div>
    </form>

@endsection
