<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('product_type_id')->unsigned();
            $table->bigInteger('locale_id')->unsigned();
            $table->foreign('product_type_id')->references('id')->on('product_types')->cascadeOnDelete();
            $table->foreign('locale_id')->references('id')->on('locales')->cascadeOnDelete();
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
        Schema::dropIfExists('product_type_translations');
    }
}
