<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionPayoutItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'payout_id',
        'tuition_id',
        'commission_amount',
    ];

    protected $casts = [
        'commission_amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function payout()
    {
        return $this->belongsTo(CommissionPayout::class, 'payout_id');
    }

    public function tuition()
    {
        return $this->belongsTo(Tuition::class);
    }
}
