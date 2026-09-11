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
            'category' => 'string',
            'api_token' => 'string',
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

    public function monitors(): HasMany
    {
        return $this->hasMany(Monitor::class, 'site_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('name');
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeAcceptingLeads(Builder $query): Builder
    {
        return $query->where('accepts_leads', true)->where('category', '!=', 'hobby_game');
    }

    public function scopeHobbies(Builder $query): Builder
    {
        return $query->where('category', 'hobby_game');
    }

    public function canAcceptLeads(): bool
    {
        return (bool) ($this->accepts_leads && $this->category !== 'hobby_game');
    }

    public function validateToken(?string $token): bool
    {
        if (empty($token) || empty($this->api_token)) {
            return false;
        }

        return hash_equals($this->api_token, $token);
    }

    public function generateApiToken(): string
    {
        $prefix = 'tok_' . preg_replace('/[^a-z0-9]/', '', strtolower($this->slug ?? 'site'));
        $token = substr($prefix, 0, 16) . '_' . bin2hex(random_bytes(16));
        $this->api_token = $token;

        return $token;
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

