<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Receita e custo por cliente e por projeto. Setup e mensalidade entram
     * como receita; domínio, Cloudflare, servidor, IA e horas como custo.
     */
    public function up(): void
    {
        if (Schema::hasTable('finance_entries')) {
            return;
        }

        Schema::create('finance_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('kind', 10)->index(); // receita | custo
            $table->string('category', 30)->index(); // setup|mensalidade|dominio|dns|servidor|ia|horas|repositorio|outro
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignId('site_project_id')->nullable()->constrained('site_projects')->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->nullableMorphs('source');
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('BRL');
            $table->date('occurred_at')->index();
            $table->string('reference')->nullable(); // chave de idempotência
            $table->json('meta')->nullable();
            $table->string('owner', 20)->default('compartilhado')->index();
            $table->timestamps();
            $table->unique('reference');
            $table->index(['company_id', 'kind', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_entries');
    }
};
