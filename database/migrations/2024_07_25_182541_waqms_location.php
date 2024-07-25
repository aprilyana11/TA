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
        Schema::create('waqms_location', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable(); // Kolom created_at dan updated_at
            $table->string('longitude')->nullable(); // Kolom untuk PM2.5
            $table->string('latitude')->nullable(); // Kolom untuk PM10

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waqms_location');
    }
};
