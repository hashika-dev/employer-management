<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        // 'name' is removed, replaced by split names below
        'first_name',
        'middle_initial',
        'last_name',
        'suffix_name',
        'email',
        'employee_number',
        'password',
        'role',
        'two_factor_code',
        'two_factor_expires_at',
        'archived_at',
        'profile_completed',
        'is_setup',
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

    /* |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    // Usage: $user->full_name
    public function getFullNameAttribute()
    {
        return implode(' ', array_filter([
            $this->first_name,
            $this->middle_initial ? $this->middle_initial . '.' : null,
            $this->last_name,
            $this->suffix_name
        ]));
    }

    /* |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /* |--------------------------------------------------------------------------
    | 2FA Functions
    |--------------------------------------------------------------------------
    */

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