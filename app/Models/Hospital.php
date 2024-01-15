<?php
// app/Models/Patient.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'contact', 'email', 'qrcode','user_id'
    ];

/**
 * Get the user that owns the Hospital
 *

 */
public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}
/**
 * Get all of the comments for the Hospital
 *
 * 
 */


 public function patients(): HasMany
{
    return $this->hasMany(Patient::class, 'user_id');
}
}
