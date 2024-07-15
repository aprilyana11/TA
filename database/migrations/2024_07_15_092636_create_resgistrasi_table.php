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
        Schema::create('registrasi', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->unique();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('password');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->float('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resgistrasi');
    }
};
