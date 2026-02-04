<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bn_name',
        'parent_id',
        'level',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Area::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Area::class, 'parent_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDivisions($query)
    {
        return $query->where('level', 'Division');
    }

    public function scopeDistricts($query)
    {
        return $query->where('level', 'District');
    }

    public function scopeAreas($query)
    {
        return $query->where('level', 'Area');
    }

    public function scopeByParent($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    // Methods
    public function getDistricts()
    {
        if ($this->level === 'Division') {
            return $this->children()->where('level', 'District')->active()->get();
        }
        return collect();
    }

    public function getAreas()
    {
        if ($this->level === 'District') {
            return $this->children()->where('level', 'Area')->active()->get();
        }
        return collect();
    }

    // Accessors
    public function getFullNameAttribute()
    {
        $parts = [$this->name];
        
        if ($this->parent) {
            $parts[] = $this->parent->name;
            
            if ($this->parent->parent) {
                $parts[] = $this->parent->parent->name;
            }
        }
        
        return implode(', ', $parts);
    }
}
