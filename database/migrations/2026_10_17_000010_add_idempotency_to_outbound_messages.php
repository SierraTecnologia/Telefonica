<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outbound_messages', function (Blueprint $table): void {
            if (! Schema::hasColumn('outbound_messages', 'idempotency_key')) {
                $table->string('idempotency_key', 100)->nullable()->unique()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('outbound_messages', function (Blueprint $table): void {
            if (Schema::hasColumn('outbound_messages', 'idempotency_key')) {
                $table->dropColumn('idempotency_key');
            }
        });
    }
};
