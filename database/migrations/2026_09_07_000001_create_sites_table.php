<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('sites')) {
            Schema::create('sites', function (Blueprint $table) {
                $table->id();
                // `slug` é o domínio (ricasolucoes.com.br). É ele que o formulário
                // manda no POST e o que autoriza a origem no CORS — por isso único.
                $table->string('slug')->unique();
                $table->string('name');
                $table->string('kind')->default('site'); // site | app | subdominio
                $table->string('color', 9)->default('#2563eb');

                // Para onde o lead é encaminhado assim que chega.
                $table->string('owner_name')->nullable();
                $table->string('notify_email')->nullable();
                $table->string('whatsapp', 20)->nullable(); // E.164 sem "+": 5521999193898

                $table->boolean('accepts_leads')->default(true);
                $table->boolean('active')->default(true);
                $table->unsignedSmallInteger('position')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
