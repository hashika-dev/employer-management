<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Get the users for the department.
     * Useful for Auth/Login related queries.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the employees for the department.
     * Useful for Staff Directory and HR queries.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}