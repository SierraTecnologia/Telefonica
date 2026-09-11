<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * O site que o cliente comprou, do briefing ao ar.
     */
    public function up(): void
    {
        if (Schema::hasTable('site_projects')) {
            return;
        }

        Schema::create('site_projects', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('client_account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            // O site cadastrado na própria Central quando o projeto vai ao ar:
            // é ele que recebe os leads do cliente e alimenta o monitor.
            $table->foreignId('site_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 30)->default('aguardando_acesso')->index();

            $table->string('domain')->nullable();
            $table->string('domain_mode', 20)->nullable(); // novo | existente
            $table->string('domain_status', 30)->nullable();

            $table->json('briefing')->nullable();
            $table->unsignedTinyInteger('briefing_progress')->default(0);
            $table->timestamp('briefing_completed_at')->nullable();

            $table->timestamp('meeting_at')->nullable();
            $table->foreignId('meeting_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('meeting_url', 512)->nullable();
            $table->text('meeting_notes')->nullable();

            // Estado de cada passo do provisionamento: {passo: {status, detalhe, em}}.
            $table->json('steps')->nullable();
            $table->string('repo_branch')->nullable();
            $table->unsignedInteger('pr_number')->nullable();
            $table->string('pr_url', 512)->nullable();
            $table->timestamp('published_at')->nullable();

            $table->string('owner', 20)->default('compartilhado')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_projects');
    }
};
