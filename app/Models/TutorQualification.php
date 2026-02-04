<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'level',
        'degree_name',
        'group_name',
        'institution',
        'board',
        'passing_year',
        'result',
        'status',
    ];

    protected $casts = [
        'passing_year' => 'integer',
    ];

    // Relationships
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeStudying($query)
    {
        return $query->where('status', 'Studying');
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}
