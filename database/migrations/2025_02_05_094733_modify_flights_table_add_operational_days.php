<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->json('operational_days')->after('duration');
            $table->index(['origin', 'destination']);
            $table->index('departure');
            $table->index('available_seats');
        });
    }
    
    public function down()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn('operational_days');
            $table->dropIndex(['origin', 'destination']);
            $table->dropIndex(['departure']);
            $table->dropIndex(['available_seats']);
        });
    }
};
