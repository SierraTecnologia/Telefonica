<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sites') && ! Schema::hasColumn('sites', 'company_id')) {
            Schema::table('sites', function (Blueprint $table) {
                $table->foreignId('company_id')->nullable()->after('id')->constrained('companies')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('sites') && Schema::hasColumn('sites', 'company_id')) {
            Schema::table('sites', function (Blueprint $table) {
                $table->dropConstrainedForeignId('company_id');
            });
        }
    }
};
