<?php

declare(strict_types=1);

namespace Telefonica\Models\Digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Telefonica\Models\Commercial\Order;
use Telefonica\Models\Crm\Lead;

class FunnelVisit extends Model
{
    protected $table = 'funnel_visits';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
            'last_seen_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (FunnelVisit $visita): void {
            $visita->uuid ??= (string) Str::uuid();
            $visita->visited_at ??= now();
        });
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
