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
        Schema::create('bloodcamps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->date('date');
            $table->text('description');
            $table->string('slug')->unique(); // Add slug column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloodcamps');
    }
};
