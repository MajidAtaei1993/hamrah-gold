<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    
    protected $fillable = [
        "user_id",
        "type",
        "weight",
        "price",
        "fee"
    ];
    protected $casts = [
        'weight' => 'float',
        'price'  => 'float',
        'fee'    => 'float',
    ];

    // types constants
    public const TYPE_BUY   = 'buy';
    public const TYPE_SELL   = 'sell';

    public const TYPES = [
        self::TYPE_BUY,
        self::TYPE_SELL,
    ];

    
    //  helper methods to check type
    public function isValidType(string $type): bool
    {
        return in_array($type, self::TYPES);
    }
    
    // etch transaction belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    // Calculate total transaction amount
    public function getTotalPriceAttribute(): string
    {
        $totlaPrice = ($this->price * $this->weight) + $this->fee;
        return $this->convertIrPrice($totlaPrice);
    }
    // Formatted price
    public function getIrPriceAttribute(): string
    {
        return $this->convertIrPrice($this->price);
    }

    // Format number as IRR
    public function convertIrPrice($price): string
    {
        return number_format($price, 0, '.', ',');
    }

    // calc total_orders
    public function getTotalAttribute() : string
    {
        $total_orders = Transaction::query()->sum(self::raw('price * weight + fee'));
        return number_format($total_orders, 0, '.', ',');
    }
}
