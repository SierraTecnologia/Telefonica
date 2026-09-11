<?php

declare(strict_types=1);

namespace Telefonica\Models\Actors\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Telefonica\Models\Actors\Business;

class Product extends Model
{
    protected $table = 'business_products';

    protected $guarded = [];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'user_id', 'id');
    }
}