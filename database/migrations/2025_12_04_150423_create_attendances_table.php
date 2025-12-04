<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->string('employee_id'); // The ID scanned from the QR code
        $table->date('date');          // The date of attendance
        $table->time('time_in');       // Time they arrived
        $table->time('time_out')->nullable(); // Time they left (nullable initially)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
