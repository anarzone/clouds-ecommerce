<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->string('shipping_address');
            $table->string('shipping_floor');
            $table->string('shipping_country');
            $table->string('shipping_city');
            $table->integer('status');
            $table->decimal('tax',8,2)->nullable();
            $table->decimal('subtotal',8,2);
            $table->decimal('delivery',8,2);
            $table->decimal('total',8,2);
            $table->decimal('reward',8,2)->nullable();
            $table->decimal('gift_cart',8,2)->nullable();
            $table->decimal('debit_cart',8,2)->nullable();
            $table->longText('note');
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
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
        Schema::dropIfExists('orders');
    }
}
