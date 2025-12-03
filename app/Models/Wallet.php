<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class)->orderBy('created_at', 'desc');
    }

    /**
     * Add money to wallet
     */
    public function credit(float $amount, string $description, string $referenceType = null, int $referenceId = null): WalletTransaction
    {
        $this->balance += $amount;
        $this->save();

        return $this->transactions()->create([
            'user_id' => $this->user_id,
            'type' => 'credit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }

    /**
     * Deduct money from wallet
     */
    public function debit(float $amount, string $description, string $referenceType = null, int $referenceId = null): WalletTransaction
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient wallet balance');
        }

        $this->balance -= $amount;
        $this->save();

        return $this->transactions()->create([
            'user_id' => $this->user_id,
            'type' => 'debit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }
}
