<?php

namespace App\Models;

use Database\Factories\WishListFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishList extends Model
{
    /** @use HasFactory<\Database\Factories\WishListFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'comment',
    ];

    public $timestamps = false;

    protected $casts = [
        'creates_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
