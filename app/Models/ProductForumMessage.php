<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductForumMessage extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'parent_id',
        'message',
        'is_official',
    ];

    protected $casts = [
        'is_official' => 'boolean',
    ];

    /**
     * Get the product that owns the message.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who wrote the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent message if this is a reply.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductForumMessage::class, 'parent_id');
    }

    /**
     * Get all replies to this message.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ProductForumMessage::class, 'parent_id')
            ->with('user')
            ->latest();
    }

    /**
     * Check if this message is by the product owner.
     */
    public function isFromProductOwner(): bool
    {
        return $this->user_id === $this->product->user_id;
    }
}
