<?php

declare(strict_types=1);

namespace Telefonica\Models\Infrastructure;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'servers';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'specs' => 'array',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeProvider(Builder $query, string $provider): Builder
    {
        return $query->where('provider', $provider);
    }
}
