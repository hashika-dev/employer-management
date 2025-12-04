<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Moving columns from 'employees' to 'users'
            $table->string('job_title')->nullable()->after('email');
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete()->after('job_title');
            $table->string('phone')->nullable()->after('department_id');
            $table->string('gender')->nullable()->after('phone');
            $table->date('birthday')->nullable()->after('gender');
            $table->text('address')->nullable()->after('birthday');
            
            // Emergency Contact Info
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_relation')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn([
                'job_title', 'department_id', 'phone', 'gender', 
                'birthday', 'address', 'emergency_name', 
                'emergency_phone', 'emergency_relation'
            ]);
        });
    }
};