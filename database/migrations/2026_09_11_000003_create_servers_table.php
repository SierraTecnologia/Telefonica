<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('servers')) {
            Schema::create('servers', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('ip')->nullable();
                $table->string('provider')->default('OCI');
                $table->string('purpose')->nullable();
                $table->string('os')->default('Linux');
                $table->string('ssh_user')->default('ubuntu');
                $table->string('status')->default('active');
                $table->json('specs')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
