<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * O projeto pode ser site, sistema ou app; ganha repositório próprio em
     * nome do cliente, documentação gerada e a aprovação do modelo.
     */
    public function up(): void
    {
        Schema::table('site_projects', function (Blueprint $table): void {
            if (! Schema::hasColumn('site_projects', 'product')) {
                $table->string('product', 20)->default('site')->after('status')->index();
            }
            if (! Schema::hasColumn('site_projects', 'reference_links')) {
                $table->json('reference_links')->nullable()->after('briefing');
            }
            if (! Schema::hasColumn('site_projects', 'repo_url')) {
                $table->string('repo_url', 512)->nullable()->after('repo_branch');
            }
            if (! Schema::hasColumn('site_projects', 'repo_full_name')) {
                $table->string('repo_full_name')->nullable()->after('repo_url');
            }
            if (! Schema::hasColumn('site_projects', 'kickoff_at')) {
                $table->timestamp('kickoff_at')->nullable()->after('published_at');
            }
            if (! Schema::hasColumn('site_projects', 'docs_generated_at')) {
                $table->timestamp('docs_generated_at')->nullable()->after('kickoff_at');
            }
            if (! Schema::hasColumn('site_projects', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('docs_generated_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_projects', function (Blueprint $table): void {
            $table->dropIndex(['product']);
            $table->dropColumn(['product', 'reference_links', 'repo_url', 'repo_full_name', 'kickoff_at', 'docs_generated_at', 'approved_at']);
        });
    }
};
