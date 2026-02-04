<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'father_name',
        'mother_name',
        'subjects',
        'class_levels',
        'preferred_areas',
        'teaching_mode',
        'salary_min',
        'salary_max',
        'available_days',
        'available_time',
        'experience_years',
    ];

    protected $casts = [
        'subjects' => 'array',
        'class_levels' => 'array',
        'preferred_areas' => 'array',
        'available_days' => 'array',
        'available_time' => 'array',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'experience_years' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function qualifications()
    {
        return $this->hasMany(TutorQualification::class);
    }

    public function documents()
    {
        return $this->hasMany(TutorDocument::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function tuitions()
    {
        return $this->hasMany(Tuition::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewed_user_id', 'user_id');
    }

    // Accessors
    public function getSubjectsArrayAttribute()
    {
        return $this->subjects ?? [];
    }

    public function getAreasArrayAttribute()
    {
        return $this->preferred_areas ?? [];
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('is_visible', true)->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->where('is_visible', true)->count();
    }

    public function getHighestQualificationAttribute()
    {
        $order = ['PhD', 'Masters', 'Bachelors', 'Diploma', 'HSC', 'SSC', 'Other'];
        $qualification = $this->qualifications()
            ->orderByRaw("FIELD(level, '" . implode("','", $order) . "')")
            ->first();
        
        return $qualification ? $qualification->level : null;
    }

    // Scopes
    public function scopeWithSubject($query, $subjectId)
    {
        return $query->whereJsonContains('subjects', $subjectId);
    }

    public function scopeWithClassLevel($query, $classLevelId)
    {
        return $query->whereJsonContains('class_levels', $classLevelId);
    }

    public function scopeInArea($query, $areaId)
    {
        return $query->whereJsonContains('preferred_areas', $areaId);
    }

    public function scopeByTeachingMode($query, $mode)
    {
        return $query->where('teaching_mode', $mode);
    }

    public function scopeBySalaryRange($query, $min, $max)
    {
        return $query->where('salary_min', '<=', $max)
            ->where('salary_max', '>=', $min);
    }
}
