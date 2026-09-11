<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Visitas por dia e página dos sites de clientes.
     *
     * Contador agregado, sem IP nem cookie: é o bastante para o cliente ver o
     * site crescer no app e não cria dado pessoal para guardar.
     */
    public function up(): void
    {
        if (Schema::hasTable('site_pageviews')) {
            return;
        }

        Schema::create('site_pageviews', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->date('day');
            $table->string('path', 191)->default('/');
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();

            $table->unique(['site_id', 'day', 'path']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_pageviews');
    }
};
