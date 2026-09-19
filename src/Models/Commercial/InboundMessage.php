<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Mensagem recebida no número oficial (WhatsApp), ligada a quem a mandou.
 */
class InboundMessage extends Model
{
    protected $table = 'inbound_messages';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'raw' => 'array',
            'received_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }
}
