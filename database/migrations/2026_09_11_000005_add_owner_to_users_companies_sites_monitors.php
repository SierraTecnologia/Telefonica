<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Divisão Sierra / Alessandro.
     *
     * O dono mora na empresa, no site e no monitor — lead, pedido e cliente
     * herdam do site por onde entraram. O default é "sierra" porque tudo o que
     * existia antes desta migration era dele; o que for do Alessandro é
     * reatribuído pelo painel.
     */
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table): void {
                if (! Schema::hasColumn('users', 'owner')) {
                    $table->string('owner', 20)->default('sierra');
                }
                // Quem pode ser escolhido para a reunião com o cliente.
                if (! Schema::hasColumn('users', 'takes_meetings')) {
                    $table->boolean('takes_meetings')->default(false);
                }
            });
        }

        foreach (['companies', 'sites', 'monitors'] as $tabela) {
            Schema::table($tabela, function (Blueprint $table) use ($tabela): void {
                if (! Schema::hasColumn($tabela, 'owner')) {
                    $table->string('owner', 20)->default('sierra')->index();
                }
            });
        }
    }

    public function down(): void
    {
        foreach (['companies', 'sites', 'monitors'] as $tabela) {
            Schema::table($tabela, function (Blueprint $table) use ($tabela): void {
                if (Schema::hasColumn($tabela, 'owner')) {
                    $table->dropIndex(['owner']);
                    $table->dropColumn('owner');
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table): void {
                $columnsToDrop = [];
                if (Schema::hasColumn('users', 'owner')) {
                    $columnsToDrop[] = 'owner';
                }
                if (Schema::hasColumn('users', 'takes_meetings')) {
                    $columnsToDrop[] = 'takes_meetings';
                }
                if (! empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }
    }
};
