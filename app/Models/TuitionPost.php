<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TuitionPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_code',
        'posted_by',
        'posted_by_type',
        'partner_id',
        'student_name',
        'student_gender',
        'student_class',
        'institution_name',
        'curriculum',
        'medium',
        'subjects',
        'preferred_tutor_gender',
        'special_requirements',
        'division',
        'district',
        'area',
        'full_address',
        'teaching_mode',
        'days_per_week',
        'preferred_days',
        'preferred_time',
        'budget_min',
        'budget_max',
        'commission_amount',
        'contact_name',
        'contact_mobile',
        'contact_relation',
        'status',
        'expires_at',
        'reviewed_at',
        'reviewed_by',
        'view_count',
        'application_count',
    ];

    protected $casts = [
        'subjects' => 'array',
        'preferred_days' => 'array',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'days_per_week' => 'integer',
        'view_count' => 'integer',
        'application_count' => 'integer',
        'expires_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    // Relationships
    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function partner()
    {
        return $this->belongsTo(TuitionPartner::class, 'partner_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function tuition()
    {
        return $this->hasOne(Tuition::class, 'post_id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeByArea($query, $area)
    {
        return $query->where('area', $area);
    }

    public function scopeBySubject($query, $subjectId)
    {
        return $query->whereJsonContains('subjects', $subjectId);
    }

    public function scopeByTeachingMode($query, $mode)
    {
        return $query->where('teaching_mode', $mode);
    }

    public function scopeByBudgetRange($query, $min, $max)
    {
        return $query->where('budget_min', '<=', $max)
            ->where('budget_max', '>=', $min);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'Draft');
    }

    public function scopeFilled($query)
    {
        return $query->where('status', 'Filled');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'Expired')
            ->orWhere(function ($q) {
                $q->whereNotNull('expires_at')
                    ->where('expires_at', '<=', now());
            });
    }

    // Methods
    public function generatePostCode()
    {
        return generateCode('TT', 5);
    }

    public function isPartnerPost()
    {
        return $this->posted_by_type === 'Partner' && !is_null($this->partner_id);
    }

    public function incrementViews()
    {
        $this->increment('view_count');
    }

    public function setExpiry($days = null)
    {
        $days = $days ?? config('findtutors.post_expiry_days', 30);
        $this->expires_at = Carbon::now()->addDays($days);
        $this->save();
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function canApply()
    {
        return $this->status === 'Active' && !$this->isExpired();
    }

    // Accessors
    public function getBudgetRangeAttribute()
    {
        return formatMoney($this->budget_min) . ' - ' . formatMoney($this->budget_max);
    }

    public function getPostedTimeAgoAttribute()
    {
        return timeAgo($this->created_at);
    }
}
