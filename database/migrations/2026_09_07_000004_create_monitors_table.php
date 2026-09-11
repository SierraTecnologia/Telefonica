<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('monitors')) {
            Schema::create('monitors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('site_id')->nullable()->constrained()->nullOnDelete();
                $table->string('name');
                $table->string('url', 512);
                $table->boolean('enabled')->default(true);

                // O que conta como "no ar"
                $table->unsignedSmallInteger('expected_status')->default(200);
                // Palavra que precisa aparecer no HTML. Pega o caso em que o Nginx
                // responde 200 servindo uma página de erro do app.
                $table->string('expected_text')->nullable();
                $table->unsignedSmallInteger('timeout_seconds')->default(15);
                $table->unsignedSmallInteger('interval_minutes')->default(5);
                // Quantas falhas seguidas antes de avisar — evita alerta por soluço de rede.
                $table->unsignedTinyInteger('failure_threshold')->default(2);

                // Estado corrente
                $table->string('status')->default('desconhecido'); // no_ar|fora_do_ar|desconhecido
                $table->timestamp('last_checked_at')->nullable();
                $table->timestamp('status_changed_at')->nullable();
                $table->unsignedSmallInteger('last_http_status')->nullable();
                $table->unsignedInteger('last_response_ms')->nullable();
                $table->text('last_failure_reason')->nullable();
                $table->unsignedSmallInteger('consecutive_failures')->default(0);

                // Certificado — o segundo jeito mais comum de um site "sumir"
                $table->boolean('check_certificate')->default(true);
                $table->string('certificate_status')->nullable(); // valido|expirando|invalido
                $table->timestamp('certificate_expires_at')->nullable();
                $table->string('certificate_issuer')->nullable();
                $table->text('certificate_error')->nullable();

                $table->string('notify_email')->nullable();
                $table->timestamps();

                $table->index(['enabled', 'status']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('monitors');
    }
};
