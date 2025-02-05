<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('flight_operational_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day');
            $table->timestamps();
            
            $table->unique(['flight_id', 'day']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('flight_operational_days');
    }
};
