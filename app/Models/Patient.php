<?php
// app/Models/Patient.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dob',
        'address',
        'phone_number',
        'gender',
        'qr_code', // Add this field to store the QR code path
        'user_id',
    ];

/**
 * Get the user that owns the Patient
 *
 * 
 */
public function hospital(): BelongsTo
{
    return $this->belongsTo(Hospital::class, 'user_id');
}
}
