<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Toda chamada à IA (harness) fica registrada: o que entrou, o que saiu,
     * quanto demorou, quantos tokens e quanto custou — por cliente e projeto.
     */
    public function up(): void
    {
        if (Schema::hasTable('ai_runs')) {
            return;
        }

        Schema::create('ai_runs', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kind', 40)->index(); // perguntas | modelo | texto | revisao
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignId('site_project_id')->nullable()->constrained('site_projects')->nullOnDelete();
            $table->nullableMorphs('related');
            $table->string('provider', 40)->default('harness');
            $table->string('model', 80)->nullable();
            $table->string('status', 20)->default('pendente')->index(); // pendente|rodando|concluido|falhou|manual
            $table->json('input')->nullable();
            $table->json('output')->nullable();
            $table->unsignedInteger('input_tokens')->default(0);
            $table->unsignedInteger('output_tokens')->default(0);
            $table->decimal('cost', 12, 6)->default(0);
            $table->string('currency', 3)->default('BRL');
            $table->unsignedInteger('duration_ms')->nullable();
            $table->string('external_id')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_runs');
    }
};
