<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * O que chega no número oficial do WhatsApp. Cada mensagem é ligada ao
     * lead ou cliente pelo telefone, para a conversa aparecer no painel.
     */
    public function up(): void
    {
        if (Schema::hasTable('inbound_messages')) {
            return;
        }

        Schema::create('inbound_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('channel', 20)->default('whatsapp');
            $table->string('from', 32)->index();
            $table->string('to', 32)->nullable();
            $table->string('provider_id')->nullable()->unique();
            $table->string('type', 20)->default('text');
            $table->text('body')->nullable();
            $table->string('media_url', 512)->nullable();
            $table->nullableMorphs('related');
            $table->json('raw')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index(['from', 'received_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbound_messages');
    }
};
