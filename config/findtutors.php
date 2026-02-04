<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Types
    |--------------------------------------------------------------------------
    */
    'user_types' => [
        'SUPER_ADMIN' => 1,
        'ADMIN' => 2,
        'TUTOR' => 3,
        'GUARDIAN' => 4,
        'PARTNER' => 5,
    ],

    'user_type_names' => [
        1 => 'Super Admin',
        2 => 'Admin',
        3 => 'Tutor',
        4 => 'Guardian',
        5 => 'Tuition Partner',
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile Status
    |--------------------------------------------------------------------------
    */
    'profile_status' => [
        'PENDING' => 'pending',
        'APPROVED' => 'approved',
        'REJECTED' => 'rejected',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Status
    |--------------------------------------------------------------------------
    */
    'application_status' => [
        'PENDING' => 'Pending',
        'VIEWED' => 'Viewed',
        'SHORTLISTED' => 'Shortlisted',
        'ACCEPTED' => 'Accepted',
        'REJECTED' => 'Rejected',
        'WITHDRAWN' => 'Withdrawn',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tuition Post Status
    |--------------------------------------------------------------------------
    */
    'post_status' => [
        'DRAFT' => 'Draft',
        'PENDING' => 'Pending',
        'ACTIVE' => 'Active',
        'FILLED' => 'Filled',
        'CLOSED' => 'Closed',
        'EXPIRED' => 'Expired',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tuition Status
    |--------------------------------------------------------------------------
    */
    'tuition_status' => [
        'CONFIRMED' => 'Confirmed',
        'ACTIVE' => 'Active',
        'ON_HOLD' => 'OnHold',
        'COMPLETED' => 'Completed',
        'CANCELLED' => 'Cancelled',
    ],

    /*
    |--------------------------------------------------------------------------
    | Commission Status
    |--------------------------------------------------------------------------
    */
    'commission_status' => [
        'PENDING' => 'Pending',
        'APPROVED' => 'Approved',
        'PAID' => 'Paid',
        'DISPUTED' => 'Disputed',
        'CANCELLED' => 'Cancelled',
    ],

    /*
    |--------------------------------------------------------------------------
    | Payout Status
    |--------------------------------------------------------------------------
    */
    'payout_status' => [
        'REQUESTED' => 'Requested',
        'PROCESSING' => 'Processing',
        'COMPLETED' => 'Completed',
        'FAILED' => 'Failed',
        'CANCELLED' => 'Cancelled',
    ],

    /*
    |--------------------------------------------------------------------------
    | Commission & Payout Settings
    |--------------------------------------------------------------------------
    */
    'platform_fee_percentage' => env('PLATFORM_FEE_PERCENTAGE', 10),
    'minimum_payout_amount' => env('MINIMUM_PAYOUT_AMOUNT', 1000),

    /*
    |--------------------------------------------------------------------------
    | Document Upload Settings
    |--------------------------------------------------------------------------
    */
    'upload' => [
        'max_profile_photo_size' => env('MAX_PROFILE_PHOTO_SIZE', 2048), // KB
        'max_document_size' => env('MAX_DOCUMENT_SIZE', 5120), // KB
        'allowed_image_types' => explode(',', env('ALLOWED_IMAGE_TYPES', 'jpg,jpeg,png')),
        'allowed_document_types' => explode(',', env('ALLOWED_DOCUMENT_TYPES', 'jpg,jpeg,png,pdf')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Post Expiry Settings
    |--------------------------------------------------------------------------
    */
    'post_expiry_days' => env('TUITION_POST_EXPIRY_DAYS', 30),

    /*
    |--------------------------------------------------------------------------
    | Enums
    |--------------------------------------------------------------------------
    */
    'enums' => [
        'gender' => ['Male', 'Female', 'Other'],
        'teaching_mode' => ['Online', 'Offline', 'Both'],
        'curriculum' => ['National', 'Cambridge', 'Edexcel', 'IB', 'Other'],
        'medium' => ['Bangla', 'English', 'Both'],
        'partner_type' => ['Individual', 'Organization'],
        'payment_method' => ['Bank', 'bKash', 'Nagad', 'Rocket', 'Cash', 'Other'],
        'relation_to_student' => ['Father', 'Mother', 'Brother', 'Sister', 'Uncle', 'Aunt', 'Self', 'Other'],
        'qualification_level' => ['SSC', 'HSC', 'Diploma', 'Bachelors', 'Masters', 'PhD', 'Other'],
        'qualification_status' => ['Completed', 'Studying'],
        'document_type' => ['SSC_CERTIFICATE', 'HSC_CERTIFICATE', 'STUDENT_ID', 'DEGREE_CERTIFICATE', 'OTHER'],
        'area_level' => ['Division', 'District', 'Area'],
        'reviewer_type' => ['Guardian', 'Partner'],
        'posted_by_type' => ['Guardian', 'Partner'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Days of Week
    |--------------------------------------------------------------------------
    */
    'days' => [
        'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'
    ],

    /*
    |--------------------------------------------------------------------------
    | Time Slots
    |--------------------------------------------------------------------------
    */
    'time_slots' => [
        'Morning' => 'Morning (6 AM - 12 PM)',
        'Afternoon' => 'Afternoon (12 PM - 6 PM)',
        'Evening' => 'Evening (6 PM - 10 PM)',
    ],

];
