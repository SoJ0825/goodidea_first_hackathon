<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('user_id', '10');
            $table->string('GoodIdeaCoin', '10')->nullable();
            $table->string('MerchantID', '10');
            $table->string('MerchantTradeNo', '20');
            $table->string('Merchandise', 30);
            $table->integer('Quantity');
            $table->integer('Unit_price');
            $table->string('TradeAmt','10');
            $table->string('PayAmt', '10')->nullable();
            $table->string('RtnCode', '10')->nullable();
            $table->string('RtnMsg', '20')->nullable();
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
