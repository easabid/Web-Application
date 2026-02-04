<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'type',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'profile_photo',
        'gender',
        'date_of_birth',
        'division',
        'district',
        'area',
        'address',
        'nid_number',
        'nid_front',
        'nid_back',
        'bio',
        'completed_at',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'completed_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'suspended_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'password' => 'hashed',
    ];

    // Relationships
    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function partner()
    {
        return $this->hasOne(TuitionPartner::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function approvedUsers()
    {
        return $this->hasMany(User::class, 'approved_by');
    }

    public function rejectedUsers()
    {
        return $this->hasMany(User::class, 'rejected_by');
    }

    // Scopes
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_suspended', false);
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at')->whereNull('rejected_at');
    }

    public function scopePending($query)
    {
        return $query->whereNotNull('completed_at')
            ->whereNull('approved_at')
            ->whereNull('rejected_at');
    }

    public function scopeSuspended($query)
    {
        return $query->where('is_suspended', true);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getProfileStatusAttribute()
    {
        return getProfileStatus($this);
    }

    public function getUserTypeNameAttribute()
    {
        return getUserType($this->type);
    }

    // Methods
    public function isAdmin()
    {
        return in_array($this->type, [
            config('findtutors.user_types.SUPER_ADMIN'),
            config('findtutors.user_types.ADMIN')
        ]);
    }

    public function isSuperAdmin()
    {
        return $this->type === config('findtutors.user_types.SUPER_ADMIN');
    }

    public function isTutor()
    {
        return $this->type === config('findtutors.user_types.TUTOR');
    }

    public function isGuardian()
    {
        return $this->type === config('findtutors.user_types.GUARDIAN');
    }

    public function isPartner()
    {
        return $this->type === config('findtutors.user_types.PARTNER');
    }

    public function isProfileComplete()
    {
        return !is_null($this->completed_at);
    }

    public function isApproved()
    {
        return !is_null($this->approved_at) && is_null($this->rejected_at);
    }

    public function isPending()
    {
        return $this->isProfileComplete() && is_null($this->approved_at) && is_null($this->rejected_at);
    }

    public function isRejected()
    {
        return !is_null($this->rejected_at);
    }

    public function canApply()
    {
        return $this->isTutor() && $this->isApproved() && $this->is_active && !$this->is_suspended;
    }

    public function canPost()
    {
        return ($this->isGuardian() || $this->isPartner()) && $this->isApproved() && $this->is_active && !$this->is_suspended;
    }
}
