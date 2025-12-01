<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_relation')->nullable(); // e.g. Spouse, Parent
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['emergency_name', 'emergency_phone', 'emergency_relation']);
        });
    }
};
