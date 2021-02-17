<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_filters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('campaign_id')->unsigned();
            $table->string('age_type_ids');
            $table->string('gender_type_ids');
            $table->string('category_ids');
            $table->integer('brand_id');
            $table->integer('product_type_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
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
        Schema::dropIfExists('campaign_filters');
    }
}
