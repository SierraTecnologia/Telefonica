<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('leads')) {
            Schema::create('leads', function (Blueprint $table) {
                $table->id();
                // Token público devolvido no passo 1. É por ele que o passo 2
                // enriquece o MESMO lead em vez de criar um segundo registro.
                $table->uuid('uuid')->unique();
                $table->foreignId('site_id')->constrained()->cascadeOnDelete();

                // ---- Etapa 1: o mínimo para conseguir ligar de volta ----
                $table->string('name');
                $table->string('phone', 32)->nullable();
                $table->string('phone_e164', 20)->nullable(); // normalizado p/ link do WhatsApp
                $table->string('email')->nullable();
                $table->string('need')->nullable();       // slug do chip clicado
                $table->string('need_label')->nullable(); // rótulo exibido, já no idioma do visitante

                // ---- Etapa 2: qualificação (opcional — o lead vale sem ela) ----
                $table->string('company')->nullable();
                $table->string('company_size')->nullable();
                $table->string('budget')->nullable();
                $table->string('deadline')->nullable();
                $table->text('message')->nullable();
                $table->json('extra')->nullable(); // campos livres por site

                // ---- Estado comercial ----
                $table->string('status')->default('novo'); // novo|contatado|qualificado|proposta|ganho|perdido
                $table->unsignedTinyInteger('step')->default(1); // até onde a pessoa foi
                $table->unsignedSmallInteger('score')->default(0);
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('contacted_at')->nullable();
                $table->timestamp('closed_at')->nullable();
                $table->string('lost_reason')->nullable();
                $table->decimal('deal_value', 12, 2)->nullable();

                // ---- Proveniência ----
                $table->string('page_url', 512)->nullable();
                $table->string('referrer', 512)->nullable();
                $table->string('locale', 12)->nullable();
                $table->string('utm_source')->nullable();
                $table->string('utm_medium')->nullable();
                $table->string('utm_campaign')->nullable();
                $table->string('utm_term')->nullable();
                $table->string('utm_content')->nullable();
                $table->string('ip', 45)->nullable();
                $table->string('user_agent', 512)->nullable();

                // Suspeita não descarta lead: marca. Um falso positivo aqui custa
                // um cliente real; um falso negativo custa uma linha de spam que
                // alguém apaga em dois segundos.
                $table->boolean('flagged')->default(false);
                $table->string('flag_reason')->nullable();

                $table->timestamp('notified_at')->nullable();
                $table->timestamps();

                $table->index(['site_id', 'status']);
                $table->index('created_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
