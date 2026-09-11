<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('packages')) {
            Schema::create('packages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('tagline')->nullable();
                $table->decimal('setup_price', 10, 2)->default(3000.00);
                $table->decimal('setup_price_promo', 10, 2)->default(0.00);
                $table->decimal('monthly_price', 10, 2);
                $table->json('features');
                $table->boolean('highlight')->default(false);
                $table->unsignedSmallInteger('delivery_days')->default(3);
                $table->boolean('is_active')->default(true);
                $table->unsignedSmallInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
