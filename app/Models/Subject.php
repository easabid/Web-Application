<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bn_name',
        'category',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeScience($query)
    {
        return $query->where('category', 'Science');
    }

    public function scopeCommerce($query)
    {
        return $query->where('category', 'Commerce');
    }

    public function scopeArts($query)
    {
        return $query->where('category', 'Arts');
    }

    public function scopeLanguage($query)
    {
        return $query->where('category', 'Language');
    }

    // Methods
    public static function getGroupedSubjects()
    {
        return self::active()
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');
    }
}
