<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_post_id',
        'tutor_id',
        'tutor_user_id',
        'cover_letter',
        'proposed_salary',
        'status',
        'rejection_reason',
        'applied_at',
        'viewed_at',
        'shortlisted_at',
        'responded_at',
    ];

    protected $casts = [
        'proposed_salary' => 'decimal:2',
        'applied_at' => 'datetime',
        'viewed_at' => 'datetime',
        'shortlisted_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    // Relationships
    public function tuitionPost()
    {
        return $this->belongsTo(TuitionPost::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function tutorUser()
    {
        return $this->belongsTo(User::class, 'tutor_user_id');
    }

    public function tuition()
    {
        return $this->hasOne(Tuition::class, 'application_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeViewed($query)
    {
        return $query->where('status', 'Viewed');
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', 'Shortlisted');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'Accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }

    public function scopeWithdrawn($query)
    {
        return $query->where('status', 'Withdrawn');
    }

    public function scopeByTutor($query, $tutorId)
    {
        return $query->where('tutor_id', $tutorId);
    }

    public function scopeByPost($query, $postId)
    {
        return $query->where('tuition_post_id', $postId);
    }

    // Methods
    public function markAsViewed()
    {
        if ($this->status === 'Pending') {
            $this->update([
                'status' => 'Viewed',
                'viewed_at' => now(),
            ]);
        }
    }

    public function markAsShortlisted()
    {
        $this->update([
            'status' => 'Shortlisted',
            'shortlisted_at' => now(),
        ]);
    }

    public function accept()
    {
        $this->update([
            'status' => 'Accepted',
            'responded_at' => now(),
        ]);
    }

    public function reject($reason = null)
    {
        $this->update([
            'status' => 'Rejected',
            'rejection_reason' => $reason,
            'responded_at' => now(),
        ]);
    }

    public function withdraw()
    {
        $this->update([
            'status' => 'Withdrawn',
            'responded_at' => now(),
        ]);
    }

    public function canWithdraw()
    {
        return $this->status === 'Pending';
    }

    // Accessors
    public function getAppliedTimeAgoAttribute()
    {
        return timeAgo($this->applied_at);
    }
}
