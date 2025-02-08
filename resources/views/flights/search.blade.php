
<!-- resources/views/flights/search.blade.php -->
@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="mb-3">
    <a href="{{ route('flights.index') }}" class="btn btn-secondary">New Search</a>
</div>

@if($flights->isEmpty())
    <div class="alert alert-info">No flights found matching your criteria.</div>
@else
    <div class="row">
        @foreach($flights as $flight)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $flight->airline }} ({{ $flight->airlineCode }}{{ $flight->flightNumber }})</h5>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><strong>Departure:</strong> {{ $flight->departure->format('H:i') }}</p>
                                <p class="mb-1"><strong>Origin:</strong> {{ $flight->origin }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong>Arrival:</strong> {{ $flight->arrival->format('H:i') }}</p>
                                <p class="mb-1"><strong>Destination:</strong> {{ $flight->destination }}</p>
                            </div>
                        </div>
                        <p class="mb-1"><strong>Duration:</strong> {{ $flight->duration }}</p>
                        <p class="mb-1"><strong>Price:</strong> ₹{{ number_format($flight->price, 2) }}</p>
                        <p class="mb-1"><strong>Available Seats:</strong> {{ $flight->availableSeats }}</p>
                        <form action="{{ route('flights.book') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="flight_id" value="{{ $flight->id }}">
                            <input type="hidden" name="passenger_count" value="{{ request('passengers') }}">
                            <button type="submit" class="btn btn-primary">Book Now</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection