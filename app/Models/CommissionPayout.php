<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'payout_code',
        'partner_id',
        'partner_user_id',
        'gross_amount',
        'platform_fee_percentage',
        'platform_fee_amount',
        'net_amount',
        'payment_method',
        'payment_account',
        'payment_reference',
        'payment_proof',
        'status',
        'requested_at',
        'processed_at',
        'processed_by',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'platform_fee_percentage' => 'decimal:2',
        'platform_fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(TuitionPartner::class, 'partner_id');
    }

    public function partnerUser()
    {
        return $this->belongsTo(User::class, 'partner_user_id');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function items()
    {
        return $this->hasMany(CommissionPayoutItem::class, 'payout_id');
    }

    // Scopes
    public function scopeRequested($query)
    {
        return $query->where('status', 'Requested');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'Processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'Failed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'Cancelled');
    }

    public function scopeByPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    // Methods
    public function generatePayoutCode()
    {
        return generateCode('PO', 5);
    }

    public function calculateFees($grossAmount)
    {
        return calculatePlatformFee($grossAmount);
    }

    public function markAsProcessing($adminId)
    {
        $this->status = 'Processing';
        $this->processed_at = now();
        $this->processed_by = $adminId;
        $this->save();
    }

    public function markAsCompleted($transactionReference = null, $proof = null)
    {
        $this->status = 'Completed';
        $this->completed_at = now();
        
        if ($transactionReference) {
            $this->payment_reference = $transactionReference;
        }
        
        if ($proof) {
            $this->payment_proof = $proof;
        }
        
        $this->save();

        // Mark all included commissions as paid
        foreach ($this->items as $item) {
            $item->tuition->markCommissionAsPaid();
        }

        // Update partner stats
        if ($this->partner) {
            $this->partner->total_paid += $this->net_amount;
            $this->partner->pending_payout -= $this->gross_amount;
            $this->partner->save();
        }
    }

    public function markAsFailed($reason = null)
    {
        $this->status = 'Failed';
        $this->notes = $reason;
        $this->save();
    }

    public function cancel($reason = null)
    {
        $this->status = 'Cancelled';
        $this->notes = $reason;
        $this->save();
    }

    // Accessors
    public function getFormattedGrossAmountAttribute()
    {
        return formatMoney($this->gross_amount);
    }

    public function getFormattedNetAmountAttribute()
    {
        return formatMoney($this->net_amount);
    }

    public function getTuitionCountAttribute()
    {
        return $this->items()->count();
    }
}
