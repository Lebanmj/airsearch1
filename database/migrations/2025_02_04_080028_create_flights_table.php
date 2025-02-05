<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->string('flight_number');
            $table->string('origin', 3);
            $table->string('destination', 3);
            $table->integer('available_seats');
            $table->decimal('price', 10, 2);
            $table->dateTime('departure');
            $table->dateTime('arrival');
            $table->string('duration');
            $table->timestamps();
            
            $table->unique(['airline_id', 'flight_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('flights');
    }
};
