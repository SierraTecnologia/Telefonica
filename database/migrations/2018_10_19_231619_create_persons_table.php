<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('persons')) {
            Schema::create('persons', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string('code')->unique();
                $table->primary('code');
                $table->string('name', 255)->nullable();
                $table->string('email')->nullable()->index();
                $table->text('description')->nullable();
                $table->string('cpf')->nullable();
                $table->string('birthday')->nullable();
                $table->string('facebook')->nullable();
                $table->integer('is_active')->nullable()->default(1);
                $table->float('hr_clt')->nullable();
                $table->float('hr_paid')->nullable();
                $table->float('price_hour')->nullable();
                $table->float('price_monty')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
};
