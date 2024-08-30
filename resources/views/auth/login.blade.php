@extends('layouts.main')

@section('title', 'Accesso')

@section('content')
    <!-- Stato della sessione -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-light">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-4 custom-main-color text-center">Accesso</h2>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Indirizzo Email -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                            </div>

                            <!-- Ricordami -->
                            <div class="form-check mb-3">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label text-muted">{{ __('Ricordami') }}</label>
                            </div>

                            <!-- Pulsanti -->
                            <div class="d-flex flex-column align-items-center">
                                <x-primary-button class="btn custom-main-color btn-lg mb-3 w-75">
                                    {{ __('Accedi') }}
                                </x-primary-button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-muted mb-3" href="{{ route('password.request') }}">
                                        {{ __('Hai dimenticato la password?') }}
                                    </a>
                                @endif

                                <a href="{{ route('register') }}" class="btn custom-main-color btn-lg w-75">
                                    {{ __('Registrati') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
