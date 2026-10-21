<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ai_exchange_rates')) {
            return;
        }

        Schema::create('ai_exchange_rates', function (Blueprint $table): void {
            $table->id();
            $table->string('base_currency', 3)->default('USD');
            $table->string('target_currency', 3)->default('BRL');
            $table->decimal('rate', 12, 6);
            $table->string('source', 40)->default('BCB_PTAX');
            $table->date('quote_date');
            $table->timestamps();

            $table->unique(['base_currency', 'target_currency', 'quote_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_exchange_rates');
    }
};
