<?php

declare(strict_types=1);

namespace Telefonica\Models\Digital;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Telefonica\Models\Actors\Business;
use Telefonica\Models\Crm\Lead;

class Sitio extends Model
{
    protected $table = 'sites';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'accepts_leads' => 'boolean',
            'active' => 'boolean',
            'position' => 'integer',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'company_id');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'site_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('name');
    }

    /**
     * Compatibilidade legada
     */
    public function getUrlAttribute(): ?string
    {
        return 'https://' . ($this->attributes['slug'] ?? 'ricasolucoes') . '.com.br';
    }

    public function businesses()
    {
        return $this->company();
    }
}

