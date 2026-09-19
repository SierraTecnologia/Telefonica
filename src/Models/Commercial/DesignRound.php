<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

/**
 * Rodada de modelo: perguntas da IA → respostas → fila (24h) → modelo →
 * feedback do cliente (gostou / não gostou / o quê / por quê).
 */
class DesignRound extends Model
{
    protected $table = 'design_rounds';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'number' => 'integer',
            'questions' => 'array',
            'answers' => 'array',
            'feedback' => 'array',
            'questions_at' => 'datetime',
            'answered_at' => 'datetime',
            'queued_at' => 'datetime',
            'due_at' => 'datetime',
            'delivered_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (DesignRound $rodada): void {
            $rodada->uuid ??= (string) Str::uuid();
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(SiteProject::class, 'site_project_id');
    }

    public function aiRuns(): MorphMany
    {
        return $this->morphMany(AiRun::class, 'related');
    }
}
