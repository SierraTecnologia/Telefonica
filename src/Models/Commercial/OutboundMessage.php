<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OutboundMessage extends Model
{
    protected $table = 'outbound_messages';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['sent_at' => 'datetime'];
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    public function manualUrl(): string
    {
        return 'https://wa.me/'.preg_replace('/\D/', '', (string) $this->to).'?text='.rawurlencode((string) $this->body);
    }
}
