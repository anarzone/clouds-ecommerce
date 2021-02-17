<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('option_1');
            $table->string('option_2');
            $table->bigInteger('image_id')->unsigned()->nullable();
            $table->bigInteger('product_id')->unsigned();
            $table->decimal('price',8,2);
            $table->bigInteger('quantity')->default(0);
            $table->string('sku')->nullable();
            $table->foreign('image_id')->references('id')->on('images');
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('variants');
    }
}
