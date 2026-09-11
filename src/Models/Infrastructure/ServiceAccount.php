<?php

declare(strict_types=1);

namespace Telefonica\Models\Infrastructure;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ServiceAccount extends Model
{
    protected $table = 'service_accounts';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeService(Builder $query, string $service): Builder
    {
        return $query->where('service_name', $service);
    }
}
