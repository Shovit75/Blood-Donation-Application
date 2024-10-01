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
        Schema::create('bloodreqs', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('blood_group');
            $table->string('hospital_name');
            $table->date('required_date');
            $table->text('additional_details')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('carousel')->default(false);
            $table->string('slug')->unique();
            $table->unsignedBigInteger('webuser_id');
            $table->foreign('webuser_id')->references('id')->on('webusers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloodreqs');
    }
};
