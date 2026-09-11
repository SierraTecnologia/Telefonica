<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sites', function (Blueprint $table): void {
            if (! Schema::hasColumn('sites', 'category')) {
                $table->string('category')->default('empresa')->after('kind');
            }
            if (! Schema::hasColumn('sites', 'api_token')) {
                $table->string('api_token')->nullable()->unique()->after('category');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table): void {
            if (Schema::hasColumn('sites', 'api_token')) {
                $table->dropUnique(['api_token']);
                $table->dropColumn('api_token');
            }
            if (Schema::hasColumn('sites', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
