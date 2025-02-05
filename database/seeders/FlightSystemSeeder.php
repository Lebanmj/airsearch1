<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;
use App\Models\Flight;
use App\Models\FlightOperationalDay;

class FlightSystemSeeder extends Seeder
{
    public function run()
    {
        // Sample data - you would replace this with your JSON data
        $flightData = json_decode(file_get_contents(database_path('seeders/flight_data.json')), true);
        
        // Create airlines
        $airlines = collect($flightData)->pluck('airline', 'airlineCode')->unique();
        
        foreach ($airlines as $code => $name) {
            Airline::create([
                'name' => $name,
                'code' => $code
            ]);
        }
        
        // Create flights and operational days
        foreach ($flightData as $flight) {
            $airline = Airline::where('code', $flight['airlineCode'])->first();
            
            $newFlight = Flight::create([
                'airline_id' => $airline->id,
                'flight_number' => $flight['flightNumber'],
                'origin' => $flight['origin'],
                'destination' => $flight['destination'],
                'available_seats' => $flight['availableSeats'],
                'price' => $flight['price'],
                'departure' => $flight['departure'],
                'arrival' => $flight['arrival'],
                'duration' => $flight['duration']
            ]);
            
            // Create operational days
            foreach ($flight['operationalDays'] as $day) {
                FlightOperationalDay::create([
                    'flight_id' => $newFlight->id,
                    'day' => $day
                ]);
            }
        }
    }
}