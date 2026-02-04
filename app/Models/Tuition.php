<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_code',
        'post_id',
        'application_id',
        'tutor_id',
        'tutor_user_id',
        'guardian_user_id',
        'partner_id',
        'partner_user_id',
        'agreed_salary',
        'days_per_week',
        'schedule_details',
        'started_at',
        'expected_end_at',
        'ended_at',
        'end_reason',
        'status',
        'tutor_confirmed',
        'tutor_confirmed_at',
        'guardian_confirmed',
        'guardian_confirmed_at',
        'admin_verified',
        'admin_verified_at',
        'admin_verified_by',
        'has_commission',
        'commission_amount',
        'commission_status',
        'commission_approved_at',
        'commission_approved_by',
    ];

    protected $casts = [
        'agreed_salary' => 'decimal:2',
        'days_per_week' => 'integer',
        'started_at' => 'date',
        'expected_end_at' => 'date',
        'ended_at' => 'date',
        'tutor_confirmed' => 'boolean',
        'tutor_confirmed_at' => 'datetime',
        'guardian_confirmed' => 'boolean',
        'guardian_confirmed_at' => 'datetime',
        'admin_verified' => 'boolean',
        'admin_verified_at' => 'datetime',
        'has_commission' => 'boolean',
        'commission_amount' => 'decimal:2',
        'commission_approved_at' => 'datetime',
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(TuitionPost::class, 'post_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function tutorUser()
    {
        return $this->belongsTo(User::class, 'tutor_user_id');
    }

    public function guardianUser()
    {
        return $this->belongsTo(User::class, 'guardian_user_id');
    }

    public function partner()
    {
        return $this->belongsTo(TuitionPartner::class, 'partner_id');
    }

    public function partnerUser()
    {
        return $this->belongsTo(User::class, 'partner_user_id');
    }

    public function adminVerifier()
    {
        return $this->belongsTo(User::class, 'admin_verified_by');
    }

    public function commissionApprover()
    {
        return $this->belongsTo(User::class, 'commission_approved_by');
    }

    public function commissionPayoutItems()
    {
        return $this->hasMany(CommissionPayoutItem::class, 'tuition_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'Confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'Cancelled');
    }

    public function scopeWithCommission($query)
    {
        return $query->where('has_commission', true);
    }

    public function scopeCommissionPending($query)
    {
        return $query->where('has_commission', true)
            ->where('commission_status', 'Pending');
    }

    public function scopeCommissionApproved($query)
    {
        return $query->where('has_commission', true)
            ->where('commission_status', 'Approved');
    }

    public function scopeCommissionPaid($query)
    {
        return $query->where('has_commission', true)
            ->where('commission_status', 'Paid');
    }

    // Methods
    public function generateTuitionCode()
    {
        return generateCode('TN', 5);
    }

    public function confirmByTutor()
    {
        $this->tutor_confirmed = true;
        $this->tutor_confirmed_at = now();
        
        if ($this->guardian_confirmed) {
            $this->status = 'Active';
        }
        
        $this->save();
    }

    public function confirmByGuardian()
    {
        $this->guardian_confirmed = true;
        $this->guardian_confirmed_at = now();
        
        if ($this->tutor_confirmed) {
            $this->status = 'Active';
        }
        
        $this->save();
    }

    public function verifyByAdmin($adminId)
    {
        $this->admin_verified = true;
        $this->admin_verified_at = now();
        $this->admin_verified_by = $adminId;
        $this->save();
    }

    public function approveCommission($adminId)
    {
        if ($this->has_commission) {
            $this->commission_status = 'Approved';
            $this->commission_approved_at = now();
            $this->commission_approved_by = $adminId;
            $this->save();

            // Update partner's pending payout
            if ($this->partner) {
                $this->partner->updateEarnings();
            }
        }
    }

    public function markCommissionAsPaid()
    {
        if ($this->has_commission) {
            $this->commission_status = 'Paid';
            $this->save();
        }
    }

    public function complete($reason = null)
    {
        $this->status = 'Completed';
        $this->ended_at = now();
        $this->end_reason = $reason;
        $this->save();
    }

    public function cancel($reason = null)
    {
        $this->status = 'Cancelled';
        $this->ended_at = now();
        $this->end_reason = $reason;
        $this->save();
    }

    public function isBothConfirmed()
    {
        return $this->tutor_confirmed && $this->guardian_confirmed;
    }

    // Accessors
    public function getIsPartnerTuitionAttribute()
    {
        return !is_null($this->partner_id);
    }

    public function getFormattedSalaryAttribute()
    {
        return formatMoney($this->agreed_salary);
    }
}
