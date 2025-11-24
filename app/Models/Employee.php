<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // These are the fields we created in the database
    protected $fillable = [
        'first_name', 
        'last_name', 
        'job_title', 
        'email', 
        'phone'
    ];
}