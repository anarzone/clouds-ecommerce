<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgeTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('age_type_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('age_type_id')->unsigned();
            $table->bigInteger('locale_id')->unsigned();
            $table->foreign('age_type_id')->references('id')->on('age_types')->cascadeOnDelete();
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
        Schema::dropIfExists('age_type_translations');
    }
}
