<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Optional: If you ever want to get all employees in a department
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}