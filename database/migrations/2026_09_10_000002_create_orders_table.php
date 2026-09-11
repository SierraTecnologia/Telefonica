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
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique();
                $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
                $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();

                $table->decimal('setup_amount', 10, 2);
                $table->decimal('monthly_amount', 10, 2);
                $table->string('discount_reason')->nullable();

                $table->string('payment_method')->nullable();
                $table->string('payment_status')->default('pendente');

                $table->string('asaas_customer_id')->nullable();
                $table->string('asaas_payment_id')->nullable();
                $table->text('asaas_pix_qrcode')->nullable();
                $table->text('asaas_pix_payload')->nullable();
                $table->timestamp('asaas_pix_expiration')->nullable();
                $table->timestamp('paid_at')->nullable();

                $table->string('business_type')->nullable();
                $table->string('business_name')->nullable();
                $table->text('notes')->nullable();

                $table->string('status')->default('novo');

                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('supervised_by')->nullable()->constrained('users')->nullOnDelete();

                $table->string('utm_source')->nullable();
                $table->string('utm_medium')->nullable();
                $table->string('utm_campaign')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('payment_status');
                $table->index('status');
                $table->index('lead_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
