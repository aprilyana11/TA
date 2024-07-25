<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('thing_speak_data', function (Blueprint $table) {
            $table->id();
            $table->decimal('pm25', 8, 2)->nullable(); // Kolom untuk PM2.5
            $table->decimal('pm10', 8, 2)->nullable(); // Kolom untuk PM10
            $table->decimal('temperature', 5, 2)->nullable(); // Kolom untuk suhu
            $table->decimal('humidity', 5, 2)->nullable(); // Kolom untuk kelembaban
            $table->decimal('tvoc', 8, 2)->nullable(); // Kolom untuk TVOC
            $table->decimal('eco2', 8, 2)->nullable(); // Kolom untuk eCO2
            $table->decimal('pressure', 8, 2)->nullable(); // Kolom untuk tekanan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thing_speak_data');
    }
};
