<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flight extends Model
{
    protected $fillable = [
        'airline_id',
        'flight_number',
        'origin',
        'destination',
        'available_seats',
        'price',
        'departure',
        'arrival',
        'duration'
    ];


    protected $casts = [
        'departure' => 'datetime',
        'arrival' => 'datetime',
        'price' => 'decimal:2'
    ];

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    public function operationalDays(): HasMany
    {
        return $this->hasMany(FlightOperationalDay::class);
    }
}