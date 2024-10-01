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
        Schema::table('bloodreqs', function (Blueprint $table) {
            $table->json('blood_group_required')->nullable()->after('webuser_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bloodreqs', function (Blueprint $table) {
            $table->dropColumn('blood_group_required');
        });
    }
};
