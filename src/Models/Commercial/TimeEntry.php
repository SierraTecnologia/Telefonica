<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeEntry extends Model
{
    protected $table = 'time_entries';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'hours' => 'decimal:2',
            'worked_on' => 'date',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function scopeForMonth(Builder $query, int $year, int $month): void
    {
        $query->whereYear('worked_on', $year)->whereMonth('worked_on', $month);
    }
}
