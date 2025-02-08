# Flight Search System

A Laravel-based flight search and booking system that allows users to search for flights between cities, view available options, and make bookings.

## Features

- Search flights by origin and destination
- Filter flights by multiple criteria:
  - Origin and destination dropdown selection
  - Date of travel
  - Number of passengers
- Advanced search results with:
  - Airline filtering
  - Price range filtering
  - Sort by price, duration, and departure time
  - Real-time seat availability
  - Operational days display
- Responsive design for mobile and desktop
- AJAX-based search for smooth user experience

NOTE : Book functionality has  not been worked upon as it wasnt mentioned in the email.

## Requirements

- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Node.js & NPM
- Laravel 10.x

## Installation

1. Clone the repository
```bash
git clone https://github.com/Lebanmj/airsearch1.git
cd flight-search
```

2. Install PHP dependencies
```bash
composer install
```


3. Set up environment file
```bash
cp .env.example .env
php artisan key:generate

OR
 .env_file 

 APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:2v3c0PvNfVxw0vgTW9KM4PpAk2qql1FDzM37qCnhpIo=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=airsearch
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```


4. Run migrations and seed the database
```bash
php artisan migrate
php artisan db:seed
```

## Database Structure

The system uses the following database tables:

### airlines
- id (primary key)
- name (string) - Airline name
- code (string) - Airline code (e.g., AI, 9W)
- created_at (timestamp)
- updated_at (timestamp)

### flights
- id (primary key)
- airline_id (foreign key)
- flight_number (string)
- origin (string)
- destination (string)
- departure (datetime)
- arrival (datetime)
- duration (string)
- price (decimal)
- available_seats (integer)
- created_at (timestamp)
- updated_at (timestamp)

### flight_operational_days
- id (primary key)
- flight_id (foreign key)
- day (tinyinteger) - Day of week (0-6, Sunday-Saturday)
- created_at (timestamp)
- updated_at (timestamp)

## API Routes

### GET /api/flights/search
Search for flights with the following parameters:
- origin (required, 3 characters)
- destination (required, 3 characters)
- departure_date (required, date)
- passengers (required, integer)

Response format:
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "airline": "Airline Name",
            "airlineCode": "XX",
            "flightNumber": "123",
            "origin": "ABC",
            "destination": "XYZ",
            "departure": "2024-02-08T10:00:00",
            "arrival": "2024-02-08T12:00:00",
            "duration": "2h 00m",
            "price": 5000,
            "availableSeats": 100
        }
    ]
}
```

## Directory Structure

```
flight-search/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── FlightController.php
│   │   └── Requests/
│   │       └── FlightSearchRequest.php
│   └── Models/
│       ├── Airline.php
│       ├── Flight.php
│       └── FlightOperationalDay.php
├── database/
│   ├── migrations/
│   │   ├── create_airlines_table.php
│   │   ├── create_flights_table.php
│   │   └── create_flight_operational_days_table.php
│   └── seeders/
│       ├── FlightSystemSeeder.php
│       └── flight_data.json
└── resources/
    └── views/
        └── flights/
            ├── index.blade.php
            └── search.blade.php
```

## Sample Data

The system comes with sample flight data including routes between various cities. The seed data includes:
- Multiple airlines (Jet Airways, Air India, Indigo, SpiceJet)
- Various routes with different timings
- Different price points
- Varied seat availability
- Multiple operational days



## Security

If you discover any security-related issues, please email [lebanjoycardozo@gmail.com] instead of using the issue tracker.

