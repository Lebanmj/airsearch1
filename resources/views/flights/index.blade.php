{{-- resources/views/flights/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Flight Search</h1>
        
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form id="searchForm" action="{{ route('flights.search') }}" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <label for="origin" class="form-label">Origin</label>
                        <input type="text" 
                               class="form-control @error('origin') is-invalid @enderror" 
                               id="origin" 
                               name="origin" 
                               value="{{ old('origin') }}"
                               placeholder="PNQ"
                               maxlength="3"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="destination" class="form-label">Destination</label>
                        <input type="text" 
                               class="form-control @error('destination') is-invalid @enderror" 
                               id="destination" 
                               name="destination" 
                               value="{{ old('destination') }}"
                               placeholder="DEL"
                               maxlength="3"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="departure_date" class="form-label">Departure Date</label>
                        <input type="date" 
                               class="form-control @error('departure_date') is-invalid @enderror" 
                               id="departure_date" 
                               name="departure_date" 
                               value="{{ old('departure_date') }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="passengers" class="form-label">Passengers</label>
                        <input type="number" 
                               class="form-control @error('passengers') is-invalid @enderror" 
                               id="passengers" 
                               name="passengers" 
                               value="{{ old('passengers', 1) }}"
                               min="1"
                               required>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary px-5">Search Flights</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="searchResults" class="mt-4">
            @isset($flights)
                @if($flights->isEmpty())
                    <div class="alert alert-info">
                        No flights found matching your criteria.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Airline</th>
                                    <th>Flight</th>
                                    <th>Departure</th>
                                    <th>Arrival</th>
                                    <th>Duration</th>
                                    <th>Available Seats</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($flights as $flight)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $flight->airline }}</span>
                                            <br>
                                            <small class="text-muted">{{ $flight->airlineCode }}-{{ $flight->flightNumber }}</small>
                                        </td>
                                        <td>{{ $flight->flightNumber }}</td>
                                        <td>
                                            {{ $flight->departure->format('H:i') }}
                                            <br>
                                            <small class="text-muted">{{ $flight->departure->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            {{ $flight->arrival->format('H:i') }}
                                            <br>
                                            <small class="text-muted">{{ $flight->arrival->format('d M Y') }}</small>
                                        </td>
                                        <td>{{ $flight->duration }}</td>
                                        <td>{{ $flight->availableSeats }}</td>
                                        <td>
                                            <span class="fw-bold">₹{{ number_format($flight->price, 2) }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary book-flight" 
                                                    data-flight-id="{{ $flight->id }}"
                                                    @if($flight->availableSeats < request('passengers', 1)) disabled @endif>
                                                Book Now
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endisset
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to book this flight?</p>
                    <div id="bookingDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmBooking">Confirm Booking</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize date picker
        flatpickr("#departure_date", {
            minDate: "today",
            dateFormat: "Y-m-d"
        });

        // Handle booking button clicks
        document.querySelectorAll('.book-flight').forEach(button => {
            button.addEventListener('click', function() {
                const flightId = this.dataset.flightId;
                const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
                
                // You can add AJAX call here to get flight details
                document.getElementById('bookingDetails').innerHTML = 'Loading...';
                
                // Show modal
                modal.show();
            });
        });

        // Handle booking confirmation
        document.getElementById('confirmBooking').addEventListener('click', function() {
            // Add your booking logic here
            alert('Booking functionality would go here');
        });

        // Form validation
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            const origin = document.getElementById('origin').value.toUpperCase();
            const destination = document.getElementById('destination').value.toUpperCase();
            
            if (origin === destination) {
                e.preventDefault();
                alert('Origin and destination cannot be the same');
            }
        });
    </script>
</body>
</html>