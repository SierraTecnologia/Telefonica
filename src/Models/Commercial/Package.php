<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $table = 'packages';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'highlight' => 'boolean',
            'is_active' => 'boolean',
            'setup_price' => 'decimal:2',
            'setup_price_promo' => 'decimal:2',
            'monthly_price' => 'decimal:2',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'package_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeHighlighted(Builder $query): Builder
    {
        return $query->where('highlight', true);
    }
}
