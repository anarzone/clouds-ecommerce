<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('birthdate')->nullable();
            $table->string('interested_in')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('profile_image_id')->nullable()->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('profile_image_id')->on('images')->references('id')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
