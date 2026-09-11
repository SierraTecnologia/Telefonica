<?php

declare(strict_types=1);

namespace Telefonica\Models\Actors;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Telefonica\Models\Digital\Site as SiteModel;
use Telefonica\Models\Digital\Sitio as SitioModel;
use Telefonica\Models\Crm\Lead as LeadModel;

class Business extends Model
{
    protected $table = 'companies';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'services' => 'array',
            'pricing_models' => 'array',
            'products' => 'array',
            'tech_stack' => 'array',
            'guardrails' => 'array',
            'stats' => 'array',
            'social_links' => 'array',
            'founded_year' => 'integer',
            'position' => 'integer',
        ];
    }

    public function sites(): HasMany
    {
        return $this->hasMany(SitioModel::class, 'company_id');
    }

    public function leads(): HasManyThrough
    {
        return $this->hasManyThrough(
            LeadModel::class,
            SitioModel::class,
            'company_id',
            'site_id',
            'id',
            'id'
        );
    }

    public function parentCompany(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_company_code', 'code');
    }

    public function subCompanies(): HasMany
    {
        return $this->hasMany(static::class, 'parent_company_code', 'code');
    }

    public function businessProducts(): HasMany
    {
        return $this->hasMany(Business\Product::class, 'business_code', 'code');
    }

    public function businessCollaborators(): HasMany
    {
        return $this->hasMany(Business\Collaborator::class, 'business_code', 'code');
    }

    public const ENTITY_TYPE_EMPRESA = 'empresa';
    public const ENTITY_TYPE_CLIENTE = 'cliente';
    public const ENTITY_TYPE_PROJETO_SAAS = 'projeto_saas';
    public const ENTITY_TYPE_HOBBY_GAME = 'hobby_game';

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('name');
    }

    public function scopeCompanies(Builder $query): Builder
    {
        return $query->where('entity_type', self::ENTITY_TYPE_EMPRESA);
    }

    public function scopeClients(Builder $query): Builder
    {
        return $query->where('entity_type', self::ENTITY_TYPE_CLIENTE);
    }

    public function scopeSaasProjects(Builder $query): Builder
    {
        return $query->where('entity_type', self::ENTITY_TYPE_PROJETO_SAAS);
    }

    public function scopeHobbies(Builder $query): Builder
    {
        return $query->where('entity_type', self::ENTITY_TYPE_HOBBY_GAME);
    }

    public function isOwnCompany(): bool
    {
        return ($this->entity_type ?? self::ENTITY_TYPE_EMPRESA) === self::ENTITY_TYPE_EMPRESA;
    }

    public function isClient(): bool
    {
        return ($this->entity_type ?? '') === self::ENTITY_TYPE_CLIENTE;
    }

    public function isSaasProject(): bool
    {
        return ($this->entity_type ?? '') === self::ENTITY_TYPE_PROJETO_SAAS;
    }

    public function isHobby(): bool
    {
        return ($this->entity_type ?? '') === self::ENTITY_TYPE_HOBBY_GAME;
    }

    /**
     * Compatibilidade legada
     */
    public function getDominioAttribute(): ?string
    {
        return $this->attributes['website'] ?? null;
    }

    public function getSubdominioAttribute(): ?string
    {
        return $this->attributes['code'] ?? null;
    }

    public function isDefault()
    {
        return ($this->code === 'ricasolucoes' || $this->code === 'sierratecnologia');
    }
}