<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('service_accounts')) {
            Schema::create('service_accounts', function (Blueprint $table): void {
                $table->id();
                $table->string('service_name');
                $table->string('account_identifier')->nullable();
                $table->string('purpose')->nullable();
                $table->string('status')->default('active');
                $table->string('documentation_url')->nullable();
                $table->json('meta')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('service_accounts');
    }
};
