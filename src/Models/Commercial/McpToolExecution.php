<?php

declare(strict_types=1);

namespace Telefonica\Models\Commercial;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class McpToolExecution extends Model
{
    protected $table = 'mcp_tool_executions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'result' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (McpToolExecution $exec): void {
            $exec->uuid ??= (string) Str::uuid();
        });
    }

    public function connection(): BelongsTo
    {
        return $this->belongsTo(McpConnection::class, 'mcp_connection_id');
    }

    public function user(): BelongsTo
    {
        $userModel = config('auth.providers.users.model', 'App\\Models\\User');

        return $this->belongsTo($userModel);
    }

    public function entity(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeForUser(Builder $query, mixed $user): Builder
    {
        $userId = $user instanceof Model ? $user->getKey() : $user;

        return $query->where('user_id', $userId);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }
}
