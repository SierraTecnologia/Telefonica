<?php

declare(strict_types=1);

namespace Telefonica\Models\Digital;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitor extends Model
{
    protected $table = 'monitors';

    protected $guarded = [];

    protected $attributes = [
        'enabled' => true,
        'expected_status' => 200,
        'timeout_seconds' => 15,
        'interval_minutes' => 5,
        'failure_threshold' => 2,
        'consecutive_failures' => 0,
        'check_certificate' => true,
        'status' => 'desconhecido',
    ];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'check_certificate' => 'boolean',
            'last_checked_at' => 'datetime',
            'status_changed_at' => 'datetime',
            'certificate_expires_at' => 'datetime',
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(MonitorIncident::class, 'monitor_id')->latest('started_at');
    }

    public function checks(): HasMany
    {
        return $this->hasMany(MonitorCheck::class, 'monitor_id')->latest();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('enabled', true);
    }
}
