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
        Schema::create('webusers_has_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('webusers_id');
            $table->unsignedBiginteger('roles_id');

            $table->foreign('webusers_id')->references('id')
                 ->on('webusers')->onDelete('cascade');
            $table->foreign('roles_id')->references('id')
                ->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webusers_has_roles');
    }
};
