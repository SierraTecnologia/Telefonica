<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Quem pagou e entra no app.
     *
     * Código e token são guardados só como hash: o código vai uma vez pelo
     * WhatsApp e, se se perder, gera-se outro — ninguém precisa lê-lo de volta.
     */
    public function up(): void
    {
        if (Schema::hasTable('client_accounts')) {
            return;
        }

        Schema::create('client_accounts', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('phone_e164', 20)->nullable();
            $table->string('email')->nullable();

            $table->string('access_code_hash', 64)->nullable()->index();
            $table->timestamp('access_code_expires_at')->nullable();
            $table->timestamp('access_code_sent_at')->nullable();
            $table->string('api_token_hash', 64)->nullable()->unique();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();

            $table->foreignId('cs_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('owner', 20)->default('compartilhado')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_accounts');
    }
};
