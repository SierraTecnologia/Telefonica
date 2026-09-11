<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Telefonica\Models\Crm\Lead;

class Order extends Model
{
    use SoftDeletes;

    public static string $STATUS_ANALYSIS = 'analise';
    public static string $STATUS_APPROVED = 'aprovado';
    public static string $STATUS_PENDING = 'pendente';
    public static string $STATUS_CANCELLED = 'cancelado';

    protected $table = 'orders';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'setup_amount' => 'decimal:2',
            'monthly_amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'asaas_pix_expiration' => 'datetime',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class, 'order_id');
    }
}
