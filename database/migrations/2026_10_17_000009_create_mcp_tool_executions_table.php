<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mcp_tool_executions')) {
            return;
        }

        Schema::create('mcp_tool_executions', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('mcp_connection_id')->constrained('mcp_connections')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tool', 80)->index();
            $table->string('scope', 80);
            $table->string('idempotency_key', 100);
            $table->string('arguments_hash', 64);
            $table->nullableMorphs('entity');
            $table->string('status', 30)->default('pending')->index(); // pending|completed|conflict|reconciliation_required|failed
            $table->json('result')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();

            $table->unique(['mcp_connection_id', 'idempotency_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mcp_tool_executions');
    }
};
