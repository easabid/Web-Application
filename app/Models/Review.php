<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_id',
        'reviewer_user_id',
        'reviewer_type',
        'reviewed_user_id',
        'rating',
        'review_text',
        'is_visible',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_visible' => 'boolean',
    ];

    // Relationships
    public function tuition()
    {
        return $this->belongsTo(Tuition::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }

    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeHidden($query)
    {
        return $query->where('is_visible', false);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeByReviewedUser($query, $userId)
    {
        return $query->where('reviewed_user_id', $userId);
    }

    public function scopeByReviewer($query, $userId)
    {
        return $query->where('reviewer_user_id', $userId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function hide()
    {
        $this->is_visible = false;
        $this->save();
    }

    public function show()
    {
        $this->is_visible = true;
        $this->save();
    }

    // Accessors
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function getReviewedTimeAgoAttribute()
    {
        return timeAgo($this->created_at);
    }
}
