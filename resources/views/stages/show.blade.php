@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="custom-main-color mx-2">{{ $stage->title }}</h1>

    @if($stage->image)
        <div class="card mb-4" style="width: 18rem;">
            <img src="{{ Storage::url($stage->image) }}" alt="{{ $stage->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
        </div>
    @endif

    <div class="mb-4">
        <h2 class="custom-main-color">Descrizione</h2>
        <p>{{ $stage->description }}</p>
    </div>

    <div class="mb-4 ">
        <h2 class="custom-main-color">Localizzazione</h2>
        <p><strong></strong> {{ $stage->location }}</p>
    </div>

    <!-- Mappa che mostra la posizione della tappa -->
    <div id="map" style="height: 400px; width: 100%;" class="mb-4"></div>

    <!-- Pulsanti di navigazione -->
    <a href="{{ route('days.show', $stage->day_id) }}" class="btn custom-main-color">Torna al giorno</a>
    <a href="{{ route('trips.show', $stage->day->trip_id) }}" class="btn custom-main-color">Torna al viaggio</a>
    <a href="{{ route('stages.edit', $stage->id) }}" class="btn custom-main-color">Modifica Tappa</a>

    <form action="{{ route('stages.destroy', $stage->id) }}" method="POST" class="mt-2 d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Elimina Tappa</button>
    </form>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const location = '{{ $stage->location }}';
    const map = L.map('map').setView([51.505, -0.09], 13); // Valori iniziali, la mappa verrà centrata in seguito
    let marker = null; // Per salvare il marker
    const apiKey = '{{ $apiKey }}'; // Usa la chiave API passata dal controller

    // Aggiunge le piastrelle di OpenStreetMap alla mappa
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

    // Forza la mappa a ridimensionarsi correttamente
    setTimeout(() => {
        map.invalidateSize();
    }, 200);
});
</script>
@endsection
