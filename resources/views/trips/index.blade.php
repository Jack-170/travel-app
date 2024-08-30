@extends('layouts.main')

@section('content')
<h2 class="custom-main-color my-2">I Tuoi Viaggi</h2>

<!-- Link per creare un nuovo viaggio -->
{{-- <a href="{{ route('trips.create') }}" class="btn custom-main-color mt-2">Crea Nuovo Viaggio</a> --}}

<!-- Visualizza un elenco di viaggi -->
<div class="mt-4">
    @if ($trips->isEmpty())
        <p>Nessun viaggio trovato.</p>
    @else
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th class="custom-main-color" style="border: 1px solid #ddd; padding: 8px;">Titolo</th>
                    <th class="custom-main-color" style="border: 1px solid #ddd; padding: 8px;">Destinazione</th>
                    <th class="custom-main-color" style="border: 1px solid #ddd; padding: 8px;">Data di Partenza</th>
                    <th class="custom-main-color" style="border: 1px solid #ddd; padding: 8px;">Data di Ritorno</th>
                    <th class="custom-main-color" style="border: 1px solid #ddd; padding: 8px;">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trips as $trip)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $trip->title }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $trip->destination }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $trip->leaving }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $trip->return }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">
                            <!-- Pulsanti Visualizza, Modifica ed Elimina -->
                            <a href="{{ route('trips.show', ['trip' => $trip->id, 'title' => Str::slug($trip->title)]) }}" class="btn custom-main-color btn-sm">Visualizza</a>
                            <a href="{{ route('trips.edit', $trip) }}" class="btn custom-main-color btn-sm">Modifica</a>
                            <form action="{{ route('trips.destroy', $trip) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn custom-main-color btn-sm">Elimina</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
