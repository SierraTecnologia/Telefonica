<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Telefonica\Models\Digital\Site;

class SiteProject extends Model
{
    protected $table = 'site_projects';

    protected $guarded = [];

    public const STEPS = [
        'dominio' => 'Domínio',
        'dns' => 'DNS (Cloudflare)',
        'repositorio' => 'Repositório do cliente (GitHub)',
        'docs' => 'README e documentação',
        'contas' => 'Acessos e contas do cliente',
        'modelo' => 'Modelo para aprovação (IA, até 24h)',
        'codigo' => 'Código HTML',
        'servidor' => 'Configuração do servidor',
        'pr' => 'Pull request no repositório dos sites',
        'cadastro' => 'Cadastro na Central (leads, monitor e métricas)',
    ];

    protected function casts(): array
    {
        return [
            'briefing' => 'array',
            'reference_links' => 'array',
            'steps' => 'array',
            'briefing_progress' => 'integer',
            'briefing_completed_at' => 'datetime',
            'meeting_at' => 'datetime',
            'published_at' => 'datetime',
            'kickoff_at' => 'datetime',
            'docs_generated_at' => 'datetime',
            'approved_at' => 'datetime',
            'pr_number' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (SiteProject $projeto): void {
            $projeto->uuid ??= (string) Str::uuid();
        });
    }

    public function clientAccount(): BelongsTo
    {
        return $this->belongsTo(ClientAccount::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function answer(string $chave, mixed $padrao = null): mixed
    {
        return Arr::get($this->briefing ?? [], $chave, $padrao);
    }

    public function slug(): string
    {
        return Str::slug(str_replace('.', '-', (string) $this->domain));
    }

    public function businessName(): string
    {
        return (string) ($this->answer('empresa.nome')
            ?: $this->clientAccount?->lead?->company
            ?: $this->clientAccount?->name
            ?: 'Novo cliente');
    }
}
