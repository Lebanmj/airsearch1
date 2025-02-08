<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use App\Http\Requests\FlightSearchRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    /**
     * Display the search form
     */
    public function index()
    {
        $origins = Flight::select('origin')->distinct()->pluck('origin');
        $destinations = Flight::select('destination')->distinct()->pluck('destination');
        
        return view('flights.index', compact('origins', 'destinations'));
    }
    /**
     * Handle the search request and return view with results
     */
    public function search(FlightSearchRequest $request)
    {
        $flights = $this->searchFlights($request);
        
        return view('flights.search', compact('flights'));
    }

    /**
     * Handle API search request
     */
    public function searchApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin' => 'required|string|size:3',
            'destination' => 'required|string|size:3',
            'departure_date' => 'required|date',
            'passengers' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $flights = $this->searchFlights($request);

        return response()->json([
            'status' => 'success',
            'data' => $flights
        ]);
    }

    /**
     * Show specific flight details
     */
    public function show(Flight $flight)
    {
        return view('flights.show', compact('flight'));
    }

    /**
     * Get list of airlines
     */
    public function airlines()
    {
        $airlines = Flight::select('airline', 'airlineCode')
            ->distinct()
            ->get();

        return response()->json($airlines);
    }

    /**
     * Handle flight booking
     */
    public function book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'flight_id' => 'required|exists:flights,id',
            'passenger_count' => 'required|integer|min:1',
            // Add more validation rules for booking
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Add booking logic here
        
        return response()->json([
            'status' => 'success',
            'message' => 'Flight booked successfully'
        ]);
    }

    /**
     * Core search functionality used by both web and API routes
     */
    private function searchFlights(Request $request)
    {
        $departureDate = Carbon::parse($request->departure_date);
        $dayOfWeek = $departureDate->dayOfWeek;

        return Flight::with('airline')  // Add this to get airline information
            ->where('origin', $request->origin)
            ->where('destination', $request->destination)
            ->where('available_seats', '>=', $request->passengers)
            ->whereHas('operationalDays', function($query) use ($dayOfWeek) {
                $query->where('day', $dayOfWeek);
            })
            ->orderBy('price')
            ->get()
            ->map(function ($flight) {
                return [
                    'id' => $flight->id,
                    'airline' => $flight->airline->name,
                    'airlineCode' => $flight->airline->code,
                    'flightNumber' => $flight->flight_number,
                    'origin' => $flight->origin,
                    'destination' => $flight->destination,
                    'departure' => $flight->departure,
                    'arrival' => $flight->arrival,
                    'duration' => $flight->duration,
                    'price' => $flight->price,
                    'availableSeats' => $flight->available_seats,
                ];
            });
    }
}