<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bit',
        'stripe_connect_id',
        'stripe_connect_enabled',
        'stripe_connect_created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'bit' => 'boolean',
            'stripe_connect_enabled' => 'boolean',
            'stripe_connect_created_at' => 'datetime',
        ];
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->bit === true;
    }

    /**
     * Get user's wallet
     */
    public function wallet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get or create user's wallet
     */
    public function getWalletAttribute(): Wallet
    {
        if (!$this->wallet()->exists()) {
            return $this->wallet()->create([
                'balance' => 0,
                'currency' => 'CHF',
            ]);
        }
        return $this->wallet;
    }
}
