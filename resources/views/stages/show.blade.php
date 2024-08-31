@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <!-- Titolo della tappa -->
    <h1 class="custom-main-color mb-4">{{ $stage->title }}</h1>

    <!-- Card per l'immagine -->
    @if($stage->image)
        <div class="card mb-4 shadow-sm border-0" style="max-width: 18rem;">
            <img src="{{ Storage::url($stage->image) }}" alt="{{ $stage->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <p class="card-text custom-main-color">{{ $stage->title }}</p>
            </div>
        </div>
    @endif

    <!-- Sezione di descrizione -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header custom-main-color">
            <h2 class="mb-0">Descrizione</h2>
        </div>
        <div class="card-body">
            <p>{{ $stage->description }}</p>
        </div>
    </div>

    <!-- Sezione di localizzazione -->
    <div class="mb-4">
        <h2 class="custom-main-color">Localizzazione</h2>
        <p><strong></strong> {{ $stage->location }}</p>
    </div>

    <!-- Mappa che mostra la posizione della tappa -->
    <div id="map" style="height: 400px; width: 100%;" class="mb-4"></div>

    <!-- Pulsanti di navigazione -->
    <div class="mb-4">
        <a href="{{ route('days.show', $stage->day_id) }}" class="btn custom-main-color">Torna al giorno</a>
        <a href="{{ route('trips.show', ['trip' => $stage->day->trip_id, 'title' => Str::slug($stage->day->trip->title)]) }}" class="btn custom-main-color">Torna al viaggio</a>
        <a href="{{ route('stages.edit', $stage->id) }}" class="btn custom-main-color">Modifica Tappa</a>
    </div>

    <!-- Form di eliminazione con conferma -->
    <form action="{{ route('stages.destroy', $stage->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" id="delete-stage-btn">Elimina Tappa</button>
    </form>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const location = '{{ $stage->location }}';
        const map = L.map('map').setView([51.505, -0.09], 13);
        let marker = null;
        const apiKey = '{{ $apiKey }}'; //chiave API passata dal controller

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Geocoding della location per ottenere le coordinate
        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(location)}&key=${apiKey}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.results && data.results.length > 0) {
                    const result = data.results[0];
                    const latLng = [result.geometry.lat, result.geometry.lng];

                    // Centra la mappa sulla posizione ottenuta
                    map.setView(latLng, 13);

                    // Aggiungi un marker sulla posizione
                    marker = L.marker(latLng).addTo(map);
                } else {
                    document.getElementById('map').innerText = 'Posizione non disponibile.';
                }
            })
            .catch(error => {
                console.error('Errore durante la geocodifica:', error);
                document.getElementById('map').innerText = 'Errore durante il caricamento della mappa.';
            });

        setTimeout(() => {
            map.invalidateSize();
        }, 200);

        // Conferma di eliminazione con SweetAlert2
        const deleteBtn = document.getElementById('delete-stage-btn');
        deleteBtn.addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Sei sicuro di voler eliminare questa tappa?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d32',
                cancelButtonColor: 'rgb(64, 189, 252)',
                confirmButtonText: 'Sì, elimina!',
                cancelButtonText: 'Annulla'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>

@endsection
