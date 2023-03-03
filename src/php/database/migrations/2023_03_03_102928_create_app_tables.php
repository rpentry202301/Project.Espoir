<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # delivery_destinations
        Schema::create('delivery_destinations', function (Blueprint $table) {
            $table->id();

            $table->foreign('user_id')->references('id')->on('users');
            $table->string('delivery_destination_name');
            $table->string('zipcode');
            $table->string('address');
            $table->string('telephone');

            $table->timestamps();
        });

        # orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_item_id')->references('id')->on('order_items');
            $table->foreign('delivery_destination_id')->references('id')->on('delivery_destinations');
            $table->integer('price_include_tax');
            $table->date('order_date');
            $table->string('delivery_destination_name');
            $table->string('zipcode');
            $table->string('address');
            $table->string('telephone');
            $table->integer('payment_method');

            $table->timestamps();
        });

        # order_items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('order_id')->references('id')->on('items');
            $table->integer('customed_price');
            $table->integer('quantity');

            $table->timestamps();
        });

        # primary_categories
        Schema::create('primary_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->timestamps();
        });

        # secondary_categories
        Schema::create('secondary_categories', function (Blueprint $table) {
            $table->id();

            $table->foreign('primary_category_id')->references('id')->on('primary_categories');
            $table->string('name');

            $table->timestamps();
        });

        # items
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('description');
            $table->foreign('secondary_category_id')->references('id')->on('secondary_categories');
            $table->integer('price');
            $table->string('image_file')->nullable();

            $table->timestamps();
        });

        # order_toppings
        Schema::create('order_toppings', function (Blueprint $table) {

            $table->foreign('order_item_id')->references('id')->on('order_items');
            $table->foreign('topping_id')->references('id')->on('toppings');

            $table->timestamps();
        });

        # toppings
        Schema::create('toppings', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description');
            $table->integer('price');
            $table->string('image_file')->nullable();

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
        Schema::dropIfExists('delivery_destinations');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('items');
        Schema::dropIfExists('secondary_categories');
        Schema::dropIfExists('primary_categories');
        Schema::dropIfExists('order_toppings');
        Schema::dropIfExists('toppings');
    }
};
