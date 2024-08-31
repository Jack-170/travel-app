@extends('layouts.main')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4 text-danger">File Troppo Grande</h1>
    <p class="lead">Il file che hai cercato di caricare supera il limite consentito di 2 MB.</p>
    <p>Per favore, seleziona un file più piccolo e riprova.</p>
    <a href="{{ url()->previous() }}" class="btn custom-main-color mt-3">Torna indietro</a>
</div>
@endsection
