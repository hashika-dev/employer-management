<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // --- ADD THIS NEW FUNCTION ---
    // This allows $department->users or Department::withCount('users') to work
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // (Optional) You can keep this for old code, but 'users' is the new standard
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}