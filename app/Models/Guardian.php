<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'relation_to_student',
        'student_name',
        'student_gender',
        'student_date_of_birth',
        'student_class',
        'student_institution',
        'curriculum',
        'medium',
    ];

    protected $casts = [
        'student_date_of_birth' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(TuitionPost::class, 'posted_by', 'user_id')
            ->where('posted_by_type', 'Guardian');
    }

    public function tuitions()
    {
        return $this->hasMany(Tuition::class, 'guardian_user_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_user_id', 'user_id')
            ->where('reviewer_type', 'Guardian');
    }

    // Accessors
    public function getStudentAgeAttribute()
    {
        if (!$this->student_date_of_birth) {
            return null;
        }
        return $this->student_date_of_birth->age;
    }
}
