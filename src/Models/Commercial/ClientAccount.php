<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Telefonica\Models\Actors\Company;
use Telefonica\Models\Crm\Lead;

class ClientAccount extends Model
{
    protected $table = 'client_accounts';

    protected $guarded = [];

    protected $hidden = ['access_code_hash', 'api_token_hash'];

    private const ALFABETO = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';

    protected function casts(): array
    {
        return [
            'access_code_expires_at' => 'datetime',
            'access_code_sent_at' => 'datetime',
            'activated_at' => 'datetime',
            'last_seen_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ClientAccount $conta): void {
            $conta->uuid ??= (string) Str::uuid();
        });
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(SiteProject::class);
    }

    public function currentProject(): HasOne
    {
        return $this->hasOne(SiteProject::class)->latestOfMany();
    }

    public function issueAccessCode(int $validadeDias = 30): string
    {
        $codigo = '';

        for ($i = 0; $i < 8; $i++) {
            $codigo .= self::ALFABETO[random_int(0, strlen(self::ALFABETO) - 1)];
        }

        $this->forceFill([
            'access_code_hash' => self::hashCode($codigo),
            'access_code_expires_at' => now()->addDays($validadeDias),
        ])->save();

        return substr($codigo, 0, 4).'-'.substr($codigo, 4);
    }

    public static function hashCode(string $codigo): string
    {
        $limpo = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $codigo) ?? '');

        return hash('sha256', $limpo);
    }

    public static function findByAccessCode(string $codigo): ?self
    {
        $conta = self::query()->where('access_code_hash', self::hashCode($codigo))->first();

        if ($conta === null || $conta->access_code_expires_at?->isPast()) {
            return null;
        }

        return $conta;
    }

    public function issueApiToken(): string
    {
        $token = Str::random(48);

        $this->forceFill([
            'api_token_hash' => hash('sha256', $token),
            'access_code_hash' => null,
            'access_code_expires_at' => null,
            'activated_at' => $this->activated_at ?? now(),
            'last_seen_at' => now(),
        ])->save();

        return $token;
    }

    public static function findByApiToken(?string $token): ?self
    {
        if (blank($token)) {
            return null;
        }

        return self::query()->where('api_token_hash', hash('sha256', $token))->first();
    }

    public function firstName(): string
    {
        return (string) Str::of($this->name)->trim()->explode(' ')->first();
    }
}
