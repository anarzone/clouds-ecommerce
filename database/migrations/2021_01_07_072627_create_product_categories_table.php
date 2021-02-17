<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('gender_type_id')->unsigned();
            $table->bigInteger('age_type_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('gender_type_id')->references('id')->on('gender_types')->cascadeOnDelete();
            $table->foreign('age_type_id')->references('id')->on('age_types')->cascadeOnDelete();
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
        Schema::dropIfExists('product_categories');
    }
}
