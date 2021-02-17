<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenderTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gender_type_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('gender_type_id')->unsigned();
            $table->bigInteger('locale_id')->unsigned();
            $table->foreign('gender_type_id')->references('id')->on('gender_types')->cascadeOnDelete();
            $table->foreign('locale_id')->references('id')->on('locales')->cascadeOnDelete();
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
        Schema::dropIfExists('gender_type_translations');
    }
}
