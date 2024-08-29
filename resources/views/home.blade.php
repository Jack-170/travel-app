
@extends('layouts.main')


@section('content')
<div class="my_container  h-100 d-flex justify-content-center align-items-center flex-column">

    <a href="{{ route('trips.create') }}" class="custom-main-color btn ">Nuovo Viaggio</a>
</div>
@endsection

