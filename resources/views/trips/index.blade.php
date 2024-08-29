@extends('layouts.main')

@section('content')
    <h2 class="custom-main-color">All Trips</h2>

    <!-- Link to create a new trip -->
    <a href="{{ route('trips.create') }}" class="btn custom-main-color">Create New Trip</a>

    <!-- Display a list of trips -->
    <div class="mt-4">
        @if ($trips->isEmpty())
            <p>No trips found.</p>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">Title</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Destination</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Leaving Date</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Return Date</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Actions</th>
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
                                <!-- View, Edit, and Delete buttons -->
                                <a href="{{ route('trips.show', $trip) }}" class="btn custom-main-color btn-sm">View</a>
                                <a href="{{ route('trips.edit', $trip) }}" class="btn custom-main-color btn-sm">Edit</a>
                                <form action="{{ route('trips.destroy', $trip) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn custom-main-color btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection


