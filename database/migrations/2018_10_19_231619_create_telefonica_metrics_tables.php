<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelefonicaMetricsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Um registro do banco para se ter metricas
         */
        Schema::create(
            'metrics', function (Blueprint $table) {
                $table->increments('id');
                $table->string('metricable_id')->nullable();
                $table->string('metricable_type')->nullable();
                $table->text('obs')->nullable();
                $table->timestamps();
            }
        );
        Schema::create(
            'metric_infos', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name');
                $table->string('value');
                $table->integer('metric_id');
                $table->foreign('metric_id')->references('id')->on('metrics');
                $table->timestamps();
                $table->softDeletes();
            }
        );
        Schema::create(
            'metric_stats', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name');
                $table->string('value');
                $table->integer('metric_id');
                $table->foreign('metric_id')->references('id')->on('metrics');
                $table->timestamps();
                $table->softDeletes();
            }
        );
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {



        Schema::dropIfExists('identity_metrics');
        Schema::dropIfExists('usernameables');
    }

}
