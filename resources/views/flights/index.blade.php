
<!-- resources/views/flights/index.blade.php -->
@extends('layouts.app')

@section('title', 'Search Flights')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Search Flights</div>
            <div class="card-body">
            <form id="flightSearchForm" action="{{ route('flights.search') }}" method="GET">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="origin" class="form-label">Origin</label>
                            <select class="form-select" id="origin" name="origin" required>
                                <option value="">Select Origin</option>
                                @foreach($origins as $origin)
                                    <option value="{{ $origin }}" {{ old('origin') == $origin ? 'selected' : '' }}>
                                        {{ $origin }}
                                    </option>
                                @endforeach
                            </select>
                            @error('origin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="destination" class="form-label">Destination</label>
                            <select class="form-select" id="destination" name="destination" required>
                                <option value="">Select Destination</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination }}" {{ old('destination') == $destination ? 'selected' : '' }}>
                                        {{ $destination }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destination')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departure_date" class="form-label">Departure Date</label>
                            <input type="date" class="form-control" id="departure_date" name="departure_date" 
                                required value="{{ old('departure_date') }}">
                            @error('departure_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="passengers" class="form-label">Passengers</label>
                            <input type="number" class="form-control" id="passengers" name="passengers" 
                                required min="1" value="{{ old('passengers', 1) }}">
                            @error('passengers')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Search Flights</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="searchResults" class="mt-4"></div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#flightSearchForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("api.flights.search") }}',
            type: 'GET',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#searchResults').html('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#searchResults').html(displayFlights(response.data));
                }
            },
            error: function(xhr) {
                let errors = '';
                if (xhr.status === 422) {
                    const response = xhr.responseJSON;
                    for (let field in response.errors) {
                        errors += `<div class="alert alert-danger">${response.errors[field]}</div>`;
                    }
                } else {
                    errors = '<div class="alert alert-danger">An error occurred while searching flights.</div>';
                }
                $('#searchResults').html(errors);
            }
        });
    });

    function displayFlights(flights) {
        if (flights.length === 0) {
            return '<div class="alert alert-info">No flights found matching your criteria.</div>';
        }

        let html = '<div class="row">';
        flights.forEach(flight => {
            html += `
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${flight.airline} (${flight.airlineCode}${flight.flightNumber})</h5>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Departure:</strong> ${new Date(flight.departure).toLocaleTimeString()}</p>
                                    <p class="mb-1"><strong>Origin:</strong> ${flight.origin}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Arrival:</strong> ${new Date(flight.arrival).toLocaleTimeString()}</p>
                                    <p class="mb-1"><strong>Destination:</strong> ${flight.destination}</p>
                                </div>
                            </div>
                            <p class="mb-1"><strong>Duration:</strong> ${flight.duration}</p>
                            <p class="mb-1"><strong>Price:</strong> ₹${flight.price}</p>
                            <p class="mb-1"><strong>Available Seats:</strong> ${flight.availableSeats}</p>
                            <button class="btn btn-primary mt-2" onclick="bookFlight(${flight.id})">Book Now</button>
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        return html;
    }

    function bookFlight(flightId) {
        // Implement booking functionality
        alert('Booking functionality would go here');
    }
});
</script>
@endpush