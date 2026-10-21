<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Telefonica\Models\Actors\Company;

/**
 * Uma chamada à IA (harness): entrada, saída, tokens, tempo e custo.
 */
class AiRun extends Model
{
    protected $table = 'ai_runs';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'input' => 'array',
            'output' => 'array',
            'input_tokens' => 'integer',
            'output_tokens' => 'integer',
            'cost' => 'decimal:6',
            'provider_cost_usd' => 'decimal:6',
            'exchange_rate' => 'decimal:6',
            'exchange_rate_date' => 'date',
            'duration_ms' => 'integer',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (AiRun $run): void {
            $run->uuid ??= (string) Str::uuid();
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(SiteProject::class, 'site_project_id');
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    public function totalTokens(): int
    {
        return (int) $this->input_tokens + (int) $this->output_tokens;
    }
}
