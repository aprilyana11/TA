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
        Schema::create('waqms_raw', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable(); // Kolom created_at dan updated_at
            $table->string('pm25')->nullable(); // Kolom untuk PM2.5
            $table->string('pm10')->nullable(); // Kolom untuk PM10
            $table->string('temperature')->nullable(); // Kolom untuk suhu
            $table->string('humidity')->nullable(); // Kolom untuk kelembaban
            $table->string('tvoc')->nullable(); // Kolom untuk TVOC
            $table->string('eco2')->nullable(); // Kolom untuk eCO2
            $table->string('pressure')->nullable(); // Kolom untuk tekanan
        });
        Schema::create('waqms_valid', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable(); // Kolom created_at dan updated_at
            $table->string('pm25')->nullable(); // Kolom untuk PM2.5
            $table->string('pm10')->nullable(); // Kolom untuk PM10
            $table->string('temperature')->nullable(); // Kolom untuk suhu
            $table->string('humidity')->nullable(); // Kolom untuk kelembaban
            $table->string('tvoc')->nullable(); // Kolom untuk TVOC
            $table->string('eco2')->nullable(); // Kolom untuk eCO2
            $table->string('pressure')->nullable(); // Kolom untuk tekanan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waqms_raw');
        Schema::dropIfExists('waqms_valid');
    }
};
