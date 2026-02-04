<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'partner_type',
        'organization_name',
        'trade_license',
        'trade_license_document',
        'referral_code',
        'coverage_areas',
        'experience_description',
        'preferred_payment_method',
        'bank_name',
        'bank_branch',
        'bank_account_name',
        'bank_account_number',
        'bank_routing_number',
        'bkash_number',
        'nagad_number',
        'rocket_number',
        'total_posts',
        'total_confirmed',
        'total_earnings',
        'total_paid',
        'pending_payout',
    ];

    protected $casts = [
        'coverage_areas' => 'array',
        'total_posts' => 'integer',
        'total_confirmed' => 'integer',
        'total_earnings' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'pending_payout' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(TuitionPost::class, 'partner_id');
    }

    public function tuitions()
    {
        return $this->hasMany(Tuition::class, 'partner_id');
    }

    public function payouts()
    {
        return $this->hasMany(CommissionPayout::class, 'partner_id');
    }

    // Methods
    public function generateReferralCode()
    {
        do {
            $code = 'FT-' . strtoupper(substr(uniqid(), -5));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    public function calculatePendingPayout()
    {
        return $this->tuitions()
            ->where('has_commission', true)
            ->where('commission_status', 'Approved')
            ->whereDoesntHave('commissionPayoutItems')
            ->sum('commission_amount');
    }

    public function updateEarnings()
    {
        $this->total_earnings = $this->tuitions()
            ->where('has_commission', true)
            ->whereIn('commission_status', ['Approved', 'Paid'])
            ->sum('commission_amount');

        $this->total_confirmed = $this->tuitions()->count();

        $this->pending_payout = $this->calculatePendingPayout();

        $this->save();
    }

    // Accessors
    public function getAvailableForPayoutAttribute()
    {
        return $this->pending_payout;
    }

    public function getSuccessRateAttribute()
    {
        if ($this->total_posts == 0) {
            return 0;
        }
        return round(($this->total_confirmed / $this->total_posts) * 100, 2);
    }

    // Scopes
    public function scopeIndividual($query)
    {
        return $query->where('partner_type', 'Individual');
    }

    public function scopeOrganization($query)
    {
        return $query->where('partner_type', 'Organization');
    }
}
