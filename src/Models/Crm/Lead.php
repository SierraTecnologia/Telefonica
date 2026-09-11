<?php

declare(strict_types=1);

namespace Telefonica\Models\Crm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Telefonica\Models\Digital\Site;

class Lead extends Model
{
    protected $table = 'leads';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            "extra" => "array",
            "flagged" => "boolean",
            "contacted_at" => "datetime",
            "closed_at" => "datetime",
            "notified_at" => "datetime",
            "deal_value" => "decimal:2",
            "step" => "integer",
            "score" => "integer",
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, "site_id");
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(\Illuminate\Support\Facades\Config::get("sitec.core.models.user", \App\Models\User::class), "assigned_to");
    }

    public function events(): HasMany
    {
        return $this->hasMany(LeadEvent::class, "lead_id")->latest();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(\Telefonica\Models\Commercial\Order::class, 'lead_id');
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereIn("status", [
            "novo",
            "contatado",
            "qualificado",
            "proposta",
        ]);
    }
}
