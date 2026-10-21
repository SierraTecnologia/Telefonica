<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Model;

/**
 * Cotação oficial de câmbio para conversão de custos de IA (USD/BRL).
 */
class AiExchangeRate extends Model
{
    protected $table = 'ai_exchange_rates';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'rate' => 'decimal:6',
            'quote_date' => 'date',
        ];
    }

    public function setQuoteDateAttribute(mixed $value): void
    {
        $this->attributes['quote_date'] = $value ? \Illuminate\Support\Carbon::parse($value)->toDateString() : null;
    }
}
