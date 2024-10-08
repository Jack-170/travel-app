<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel-App</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('build/assets/app-DImbUSg3.css') }}">

    <!-- Include CSS and JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .custom-header {
            background-color: #f8f9fa;
            padding:5px;
        }
        .custom-footer {
            background-color: #f8f9fa;
            padding: 5px;
        }
        .content-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar-nav.ms-auto {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <header class="custom-header">
        <div class="container">
            <h1 class="custom-main-color text-center fs-1 my-2">Travel-App</h1>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link fw-semibold custom-main-color" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold custom-main-color" href="{{ route('trips.index') }}">Viaggi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold custom-main-color" href="{{ route('trips.create') }}">Nuovo viaggio</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold custom-main-color" href="{{ route('login') }}">{{ __('Accedi') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold custom-main-color" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle custom-main-color" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="content-wrapper">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="custom-footer text-center">
        <p>&copy; {{ date('Y') }} My Application</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('build/assets/app-9rXMJxvn.js') }}"></script>


    @yield('scripts')

</body>
</html>
