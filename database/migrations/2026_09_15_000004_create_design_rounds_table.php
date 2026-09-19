<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Uma rodada de modelo: a IA pergunta, o cliente responde, entra na fila,
     * em até 24h volta um modelo, e o cliente diz se gostou, o que gostou, o
     * que não gostou e por quê. Reprovou, abre a próxima rodada.
     */
    public function up(): void
    {
        if (Schema::hasTable('design_rounds')) {
            return;
        }

        Schema::create('design_rounds', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('site_project_id')->constrained('site_projects')->cascadeOnDelete();
            $table->unsignedTinyInteger('number')->default(1);
            $table->string('status', 30)->default('perguntas')->index();
            $table->json('questions')->nullable();
            $table->json('answers')->nullable();
            $table->longText('model_html')->nullable();
            $table->string('model_url', 512)->nullable();
            $table->text('model_notes')->nullable();
            $table->json('feedback')->nullable(); // gostou, o_que_gostou, o_que_nao_gostou, porque
            $table->timestamp('questions_at')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamp('queued_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->unique(['site_project_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design_rounds');
    }
};
