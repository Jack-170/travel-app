@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="mb-4 fw-semibold custom-main-color">Aggiungi Nuova Tappa</h1>

    <form method="POST" action="{{ route('stages.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="day_id" value="{{ $day->id }}">
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Localizzazione</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required autocomplete="off">
            @error('location')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <ul id="suggestions" class="list-group mt-2"></ul>
        </div>

        <!-- Mappa che mostra la posizione selezionata -->
        <div id="map" style="height: 400px; width: 100%;" class="mb-3"></div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrizione</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Immagine</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn custom-main-color">Salva Tappa</button>
    </form>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const locationInput = document.getElementById('location');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const suggestionsList = document.getElementById('suggestions');
    const map = L.map('map').setView([51.505, -0.09], 13); // Valori iniziali (posizione centrata)
    let marker = null; // Per salvare il marker
    const apiKey = '{{ $apiKey }}'; //chiave API passata dal controller


    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    locationInput.addEventListener('input', function() {
        const location = locationInput.value;

        if (location.length > 2) {
            fetch(`https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(location)}&key=${apiKey}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.results) {
                        suggestionsList.innerHTML = '';
                        data.results.forEach(result => {
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item';
                            listItem.textContent = result.formatted;
                            listItem.dataset.latitude = result.geometry.lat;
                            listItem.dataset.longitude = result.geometry.lng;
                            listItem.addEventListener('click', function() {
                                locationInput.value = result.formatted;
                                latitudeInput.value = result.geometry.lat;
                                longitudeInput.value = result.geometry.lng;


                                const latLng = [result.geometry.lat, result.geometry.lng];
                                map.setView(latLng, 13);


                                if (marker) {
                                    map.removeLayer(marker);
                                }


                                marker = L.marker(latLng).addTo(map);

                                suggestionsList.innerHTML = '';
                            });
                            suggestionsList.appendChild(listItem);
                        });
                    } else {
                        suggestionsList.innerHTML = '<li class="list-group-item">Nessun risultato trovato</li>';
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    suggestionsList.innerHTML = '<li class="list-group-item">Errore durante la ricerca</li>';
                });
        } else {
            suggestionsList.innerHTML = '';
        }
    });

    document.addEventListener('click', function(e) {
        if (!suggestionsList.contains(e.target) && e.target !== locationInput) {
            suggestionsList.innerHTML = '';
        }
    });
});
</script>
@endsection
