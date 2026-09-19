<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cartão em até 12x: o pedido guarda o parcelamento escolhido e o link de
     * pagamento hospedado no Asaas (a Central nunca vê o número do cartão).
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            if (! Schema::hasColumn('orders', 'installments')) {
                $table->unsignedTinyInteger('installments')->default(1)->after('payment_method');
            }
            if (! Schema::hasColumn('orders', 'installment_amount')) {
                $table->decimal('installment_amount', 10, 2)->nullable()->after('installments');
            }
            if (! Schema::hasColumn('orders', 'asaas_invoice_url')) {
                $table->string('asaas_invoice_url', 512)->nullable()->after('asaas_pix_expiration');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropColumn(['installments', 'installment_amount', 'asaas_invoice_url']);
        });
    }
};
