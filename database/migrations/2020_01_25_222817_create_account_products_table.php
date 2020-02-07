<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id')->comment('会計ID');
            $table->unsignedBigInteger('product_id')->comment('商品ID');
            $table->integer('without_tax_sell_price')->comment('販売単価(税抜き)');
            $table->unsignedBigInteger('discount_id')->nullable()->comment('割引ID');
            $table->integer('product_discount_amount')->comment('商品割引金額');
            $table->integer('consumption_tax_rate')->comment('適用消費税率');
            // TODO: 消費税は全体計算
            // $table->integer('consumption_tax_amount')->comment('適用消費税金額');
            $table->integer('account_product_amount')->comment('会計商品金額');
            $table->timestamps();
            $table->softDeletes();

            // 会計テーブル
            $table->foreign('account_id')->references('id')->on('accounts');
            // 商品テーブル
            $table->foreign('product_id')->references('id')->on('products');
            // 割引テーブル
            $table->foreign('discount_id')->references('id')->on('discounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_products');
    }
}
