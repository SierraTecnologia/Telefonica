<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelefonicaUsernamesTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create(
            'identity_usernames', function (Blueprint $table) {
                $table->increments('id');
                $table->string('value')->nullable();
                $table->string('usernameable_id')->nullable();
                $table->string('usernameable_type')->nullable();
                $table->text('obs')->nullable();
                $table->timestamps();
            }
        );
        Schema::create(
            'usernameables', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->integer('username_id');
                $table->string('usernameable_id');
                $table->string('usernameable_type', 255);
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



        Schema::dropIfExists('identity_usernames');
        Schema::dropIfExists('usernameables');
    }

}
