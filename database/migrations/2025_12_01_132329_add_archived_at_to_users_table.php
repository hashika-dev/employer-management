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
    Schema::table('users', function (Blueprint $table) {
        $table->timestamp('archived_at')->nullable(); // If NULL, they are Active. If set, they are Banned.
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('archived_at');
    });
}
};
