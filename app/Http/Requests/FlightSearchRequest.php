<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'origin' => 'required|string|size:3',
            'destination' => 'required|string|size:3',
            'departure_date' => 'required|date',
            'passengers' => 'required|integer|min:1'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'origin.required' => 'Origin airport is required',
            'origin.size' => 'Airport code must be exactly 3 characters',
            'destination.required' => 'Destination airport is required',
            'destination.size' => 'Airport code must be exactly 3 characters',
            'departure_date.required' => 'Departure date is required',
            'departure_date.date' => 'Invalid date format',
            'passengers.required' => 'Number of passengers is required',
            'passengers.min' => 'At least 1 passenger is required'
        ];
    }
}