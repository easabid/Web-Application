<?php

if (!function_exists('getUserType')) {
    /**
     * Get user type name from type number
     *
     * @param int $type
     * @return string
     */
    function getUserType($type)
    {
        return config('findtutors.user_type_names.' . $type, 'Unknown');
    }
}

if (!function_exists('formatMoney')) {
    /**
     * Format amount as BDT currency
     *
     * @param float $amount
     * @param bool $showSymbol
     * @return string
     */
    function formatMoney($amount, $showSymbol = true)
    {
        $formatted = number_format($amount, 2);
        return $showSymbol ? '৳' . $formatted : $formatted;
    }
}

if (!function_exists('getProfileStatus')) {
    /**
     * Get profile status of a user
     *
     * @param \App\Models\User $user
     * @return string
     */
    function getProfileStatus($user)
    {
        if ($user->rejected_at) {
            return 'rejected';
        }
        
        if ($user->approved_at) {
            return 'approved';
        }
        
        if ($user->completed_at) {
            return 'pending';
        }
        
        return 'incomplete';
    }
}

if (!function_exists('generateCode')) {
    /**
     * Generate unique code with prefix
     *
     * @param string $prefix (TT=Tuition Post, TN=Tuition, PO=Payout, FT=Partner Referral)
     * @param int $length
     * @return string
     */
    function generateCode($prefix, $length = 5)
    {
        $year = date('Y');
        $randomNumber = str_pad(rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        return $prefix . '-' . $year . '-' . $randomNumber;
    }
}

if (!function_exists('isAdmin')) {
    /**
     * Check if user is admin (Super Admin or Admin)
     *
     * @param \App\Models\User $user
     * @return bool
     */
    function isAdmin($user)
    {
        return in_array($user->type, [
            config('findtutors.user_types.SUPER_ADMIN'),
            config('findtutors.user_types.ADMIN')
        ]);
    }
}

if (!function_exists('isSuperAdmin')) {
    /**
     * Check if user is super admin
     *
     * @param \App\Models\User $user
     * @return bool
     */
    function isSuperAdmin($user)
    {
        return $user->type === config('findtutors.user_types.SUPER_ADMIN');
    }
}

if (!function_exists('calculatePlatformFee')) {
    /**
     * Calculate platform fee from gross amount
     *
     * @param float $grossAmount
     * @return array ['fee_percentage' => float, 'fee_amount' => float, 'net_amount' => float]
     */
    function calculatePlatformFee($grossAmount)
    {
        $feePercentage = config('findtutors.platform_fee_percentage', 10);
        $feeAmount = ($grossAmount * $feePercentage) / 100;
        $netAmount = $grossAmount - $feeAmount;
        
        return [
            'fee_percentage' => $feePercentage,
            'fee_amount' => round($feeAmount, 2),
            'net_amount' => round($netAmount, 2),
        ];
    }
}

if (!function_exists('timeAgo')) {
    /**
     * Convert date to human readable time ago
     *
     * @param string|\DateTime $date
     * @return string
     */
    function timeAgo($date)
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }
        
        $now = new \DateTime();
        $diff = $now->diff($date);
        
        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        }
        if ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        }
        if ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        }
        if ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        }
        if ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        }
        
        return 'Just now';
    }
}

if (!function_exists('getStatusBadgeClass')) {
    /**
     * Get Tailwind CSS class for status badge
     *
     * @param string $status
     * @return string
     */
    function getStatusBadgeClass($status)
    {
        $statusClasses = [
            'Pending' => 'bg-yellow-100 text-yellow-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'Approved' => 'bg-green-100 text-green-800',
            'approved' => 'bg-green-100 text-green-800',
            'Rejected' => 'bg-red-100 text-red-800',
            'rejected' => 'bg-red-100 text-red-800',
            'Active' => 'bg-blue-100 text-blue-800',
            'Completed' => 'bg-gray-100 text-gray-800',
            'Cancelled' => 'bg-red-100 text-red-800',
            'Viewed' => 'bg-purple-100 text-purple-800',
            'Shortlisted' => 'bg-indigo-100 text-indigo-800',
            'Accepted' => 'bg-green-100 text-green-800',
            'Withdrawn' => 'bg-gray-100 text-gray-800',
            'Draft' => 'bg-gray-100 text-gray-800',
            'Filled' => 'bg-green-100 text-green-800',
            'Closed' => 'bg-red-100 text-red-800',
            'Expired' => 'bg-red-100 text-red-800',
        ];
        
        return $statusClasses[$status] ?? 'bg-gray-100 text-gray-800';
    }
}

if (!function_exists('uploadFile')) {
    /**
     * Upload file and return path
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string|null
     */
    function uploadFile($file, $directory = 'uploads')
    {
        if (!$file || !$file->isValid()) {
            return null;
        }
        
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');
        
        return $path;
    }
}

if (!function_exists('deleteFile')) {
    /**
     * Delete file from storage
     *
     * @param string|null $path
     * @return bool
     */
    function deleteFile($path)
    {
        if (!$path) {
            return false;
        }
        
        return \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
    }
}
