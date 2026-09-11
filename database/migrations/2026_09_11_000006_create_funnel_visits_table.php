<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Uma linha por pessoa que abriu o link do funil.
     *
     * Cada etapa grava a sua data; contar as colunas preenchidas é o funil.
     * "Pessoa" aqui é o token que o navegador guarda — recarregar a página não
     * conta visita nova.
     */
    public function up(): void
    {
        if (Schema::hasTable('funnel_visits')) {
            return;
        }

        Schema::create('funnel_visits', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('channel', 10)->default('web'); // web | app
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamp('visited_at');
            $table->timestamp('contact_at')->nullable();
            $table->timestamp('needs_at')->nullable();
            $table->timestamp('discovery_at')->nullable();
            $table->timestamp('offer_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();

            $table->string('landing_url', 512)->nullable();
            $table->string('referrer', 512)->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->timestamps();

            $table->index('visited_at');
            $table->index(['utm_source', 'visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funnel_visits');
    }
};
