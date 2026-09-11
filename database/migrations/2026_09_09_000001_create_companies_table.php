<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
                $table->string('trade_name')->nullable();
                $table->string('cnpj')->nullable();
                $table->string('registration_number')->nullable();
                $table->string('tagline')->nullable();
                $table->string('slogan')->nullable();
                $table->text('description')->nullable();
                $table->text('mission')->nullable();
                $table->text('killer_feature')->nullable();
                $table->string('category')->nullable();
                $table->string('segment')->nullable();
                $table->string('market_time')->nullable();
                $table->integer('founded_year')->nullable();
                $table->string('owner_name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('whatsapp')->nullable();
                $table->string('website')->nullable();
                $table->string('address')->nullable();
                $table->string('parent_company_code')->nullable();
                $table->json('services')->nullable();
                $table->json('pricing_models')->nullable();
                $table->json('products')->nullable();
                $table->json('tech_stack')->nullable();
                $table->text('guardrails')->nullable();
                $table->json('stats')->nullable();
                $table->json('social_links')->nullable();
                $table->string('color')->nullable()->default('#2563eb');
                $table->string('status')->default('active');
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
