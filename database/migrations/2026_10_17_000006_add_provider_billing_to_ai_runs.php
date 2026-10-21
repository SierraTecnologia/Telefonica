<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_runs', function (Blueprint $table): void {
            if (! Schema::hasColumn('ai_runs', 'provider_cost_usd')) {
                $table->decimal('cost', 12, 6)->nullable()->change();
                $table->decimal('provider_cost_usd', 12, 6)->nullable()->after('output_tokens');
                $table->decimal('exchange_rate', 12, 6)->nullable()->after('provider_cost_usd');
                $table->date('exchange_rate_date')->nullable()->after('exchange_rate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ai_runs', function (Blueprint $table): void {
            if (Schema::hasColumn('ai_runs', 'provider_cost_usd')) {
                $table->dropColumn(['provider_cost_usd', 'exchange_rate', 'exchange_rate_date']);
            }
        });
    }
};
