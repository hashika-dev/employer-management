<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // <--- Commented out or Removed

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// REMOVED "implements MustVerifyEmail"
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   // app/Models/User.php

   // Add this method inside your User class
public function getFullNameAttribute()
{
    // Logic: distinct() removes nulls, implode joins them with a space
    return implode(' ', array_filter([
        $this->first_name,
        $this->middle_initial ? $this->middle_initial . '.' : null, // Adds dot to initial
        $this->last_name,
        $this->suffix_name
    ]));
}

protected $fillable = [
    // Remove 'name',
    'first_name',      // <--- Add this
    'middle_initial',  // <--- Add this
    'last_name',       // <--- Add this
    'suffix_name',     // <--- Add this
    'email',
    'employee_number',
    'password',
    'role',
    'two_factor_code',
    'two_factor_expires_at',
    'archived_at',
    'profile_completed',
    'is_setup',
    // --- ADD THESE NEW FIELDS ---
    'job_title',
    'department_id',
    'phone',
    'gender',
    'birthday',
    'address',
    'emergency_name',
    'emergency_phone',
    'emergency_relation',
];

// --- ADD THE RELATIONSHIP ---
public function department()
{
    return $this->belongsTo(Department::class);
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_expires_at' => 'datetime',
            'archived_at' => 'datetime',
            'profile_completed' => 'boolean',
        ];
    }

    // --- 2FA FUNCTIONS ---

    public function generateCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function resetCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}