<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_cd', 10)->comment('商品CD');
            $table->string('name', 255)->comment('商品名');
            $table->unsignedBigInteger('product_category_id')->comment('商品カテゴリーID');
            $table->integer('without_tax_sell_price')->comment('販売単価(税抜き)');
            $table->timestamps();
            $table->softDeletes();

            // 外部キー設定

            // 商品カテゴリテーブル
            $table->foreign('product_category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
