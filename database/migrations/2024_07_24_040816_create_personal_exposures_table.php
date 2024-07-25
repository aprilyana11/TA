<?php

// Migrasi untuk personal_exposures
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalExposuresTable extends Migration
{
    public function up()
    {
        Schema::create('personal_exposures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->float('pm25')->nullable();
            $table->float('pm10')->nullable();
            $table->float('temperature')->nullable();
            $table->float('humidity')->nullable();
            $table->float('tvoc')->nullable();
            $table->float('eco2')->nullable();
            $table->float('pressure')->nullable();
            $table->float('exposure_dose')->nullable(); // Menyimpan dosis paparan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_exposures');
    }
}
