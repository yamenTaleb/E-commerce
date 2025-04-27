<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerSupport extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerSupportFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'category_issued',
        'description',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
