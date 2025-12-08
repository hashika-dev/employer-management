<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'employee_number',
    'first_name',
    'middle_initial', 
    'last_name',
    'suffix_name',    
    'email',
    'job_title',
    'department_id',
    'gender',
    'birthday',
    'marital_status',
    'address',
    'phone',
    'emergency_name',
    'emergency_relation',
    'emergency_phone',
    'profile_photo_path',
    'is_archived',
    'archived_at'
];

    // New Relationship Function
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}