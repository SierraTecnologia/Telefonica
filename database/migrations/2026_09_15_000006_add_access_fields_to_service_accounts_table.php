<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Acessos, contas e plataformas de cada cliente: onde entra, com qual
     * login, e a credencial cifrada. Ligados ao projeto quando nascem dele.
     */
    public function up(): void
    {
        Schema::table('service_accounts', function (Blueprint $table): void {
            if (! Schema::hasColumn('service_accounts', 'site_project_id')) {
                $table->foreignId('site_project_id')->nullable()->after('company_id')->constrained('site_projects')->nullOnDelete();
            }
            if (! Schema::hasColumn('service_accounts', 'platform')) {
                $table->string('platform', 40)->nullable()->after('service_name')->index(); // github|cloudflare|registrobr|asaas|google|meta|servidor|email|outro
            }
            if (! Schema::hasColumn('service_accounts', 'login')) {
                $table->string('login')->nullable()->after('account_identifier');
            }
            if (! Schema::hasColumn('service_accounts', 'credentials')) {
                $table->text('credentials')->nullable()->after('login');
            }
            if (! Schema::hasColumn('service_accounts', 'access_url')) {
                $table->string('access_url', 512)->nullable()->after('credentials');
            }
            if (! Schema::hasColumn('service_accounts', 'monthly_cost')) {
                $table->decimal('monthly_cost', 10, 2)->nullable()->after('access_url');
            }
            if (! Schema::hasColumn('service_accounts', 'owner')) {
                $table->string('owner', 20)->default('compartilhado')->after('monthly_cost')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_accounts', function (Blueprint $table): void {
            $table->dropIndex(['platform']);
            $table->dropIndex(['owner']);
            $table->dropConstrainedForeignId('site_project_id');
            $table->dropColumn(['platform', 'login', 'credentials', 'access_url', 'monthly_cost', 'owner']);
        });
    }
};
