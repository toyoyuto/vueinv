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
            $table->bigIncrements('id');
            $table->string('name', 255)->comment('商品カテゴリー名');
            $table->unsignedBigInteger('consumption_tax_id')->comment('消費税ID');
            $table->timestamps();
            $table->softDeletes();
            
            // 消費税テーブル
            $table->foreign('consumption_tax_id')->references('id')->on('consumption_taxs');
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
