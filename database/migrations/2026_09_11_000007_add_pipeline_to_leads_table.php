<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            if (! Schema::hasColumn('leads', 'pipeline')) {
                // comercial | cs — só preenchido para leads do funil da Central.
                $table->string('pipeline', 20)->nullable()->index();
            }
            if (! Schema::hasColumn('leads', 'funnel_stage')) {
                // Etapa mais adiante que a pessoa alcançou (espelho da visita,
                // para filtrar a fila do comercial sem join).
                $table->string('funnel_stage', 20)->nullable();
            }
            if (! Schema::hasColumn('leads', 'offer_decision')) {
                $table->string('offer_decision', 30)->nullable();
            }
            if (! Schema::hasColumn('leads', 'next_contact_at')) {
                $table->timestamp('next_contact_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            $table->dropIndex(['pipeline']);
            $table->dropColumn(['pipeline', 'funnel_stage', 'offer_decision', 'next_contact_at']);
        });
    }
};
