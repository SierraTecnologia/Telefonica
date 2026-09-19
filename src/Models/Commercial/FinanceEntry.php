<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Telefonica\Models\Actors\Company;

/**
 * Lançamento de receita ou custo, sempre ligado a um cliente e, quando
 * houver, ao projeto e ao pedido.
 */
class FinanceEntry extends Model
{
    protected $table = 'finance_entries';

    protected $guarded = [];

    public const KIND_REVENUE = 'receita';

    public const KIND_COST = 'custo';

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'occurred_at' => 'date',
            'meta' => 'array',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(SiteProject::class, 'site_project_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeRevenue(Builder $query): Builder
    {
        return $query->where('kind', self::KIND_REVENUE);
    }

    public function scopeCost(Builder $query): Builder
    {
        return $query->where('kind', self::KIND_COST);
    }
}
