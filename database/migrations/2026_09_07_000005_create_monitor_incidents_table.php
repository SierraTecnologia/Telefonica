<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('monitor_incidents')) {
            Schema::create('monitor_incidents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('monitor_id')->constrained()->cascadeOnDelete();
                $table->timestamp('started_at');
                $table->timestamp('ended_at')->nullable();
                $table->unsignedInteger('duration_seconds')->nullable();
                $table->text('reason')->nullable();
                $table->unsignedSmallInteger('http_status')->nullable();
                $table->timestamps();

                $table->index(['monitor_id', 'started_at']);
            });
        }

        if (! Schema::hasTable('monitor_checks')) {
            Schema::create('monitor_checks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('monitor_id')->constrained()->cascadeOnDelete();
                $table->string('status');
                $table->unsignedSmallInteger('http_status')->nullable();
                $table->unsignedInteger('response_ms')->nullable();
                $table->text('error')->nullable();
                $table->timestamp('created_at')->nullable();

                $table->index(['monitor_id', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('monitor_checks');
        Schema::dropIfExists('monitor_incidents');
    }
};
