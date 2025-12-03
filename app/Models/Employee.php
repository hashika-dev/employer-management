<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'job_title', 
        'email', 
        'phone',
        // HR Fields
        'address',
        'birthday',
        'age',
        'marital_status',
        // NEW EMERGENCY FIELDS (Make sure these are here!)
        'emergency_name',
        'emergency_phone',
        'emergency_relation',
        'department_id', // <--- ADD THIS
        'gender', // <--- ADD THIS
    ];

    // New Relationship Function
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}