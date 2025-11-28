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
    // 1. Add Status to Users table (For Approval)
    Schema::table('users', function (Blueprint $table) {
        $table->string('status')->default('pending'); // Default is PENDING
    });

    // 2. Add Personal Info to Employees table (For Profile)
    Schema::table('employees', function (Blueprint $table) {
        $table->integer('age')->nullable();
        $table->string('marital_status')->nullable();
        $table->text('address')->nullable();
        $table->date('birthday')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
