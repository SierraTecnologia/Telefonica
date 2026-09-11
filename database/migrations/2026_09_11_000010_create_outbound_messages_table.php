<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Toda mensagem que a Central manda (ou deveria ter mandado) pelo WhatsApp.
     *
     * Existe pelo mesmo motivo da tabela de leads: um envio que falha não pode
     * sumir. Se o WAHA não respondeu, a linha fica "falhou" no painel com o
     * link wa.me pronto para alguém mandar à mão.
     */
    public function up(): void
    {
        if (Schema::hasTable('outbound_messages')) {
            return;
        }

        Schema::create('outbound_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('channel', 20)->default('whatsapp');
            $table->string('to', 32);
            $table->text('body');
            $table->nullableMorphs('related');
            $table->string('status', 20)->default('pendente'); // pendente|enviado|falhou|manual
            $table->string('provider_id')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outbound_messages');
    }
};
