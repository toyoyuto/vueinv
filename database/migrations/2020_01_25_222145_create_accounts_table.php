<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->comment('スタッフID');
            $table->unsignedBigInteger('store_id')->comment('店舗ID');
            $table->integer('total_product_amount')->comment('合計商品金額');
            $table->integer('tax_amount_1_product_amount')->comment('消費税率(8%)適用金額');
            $table->integer('tax_amount_1')->comment('消費税金額(8%)');
            $table->integer('tax_amount_2_product_amount')->comment('消費税率(10%)適用金額');
            $table->integer('tax_amount_2')->comment('消費税金額(10%)');
            $table->integer('total_tax_amount')->comment('合計消費税金額');
            $table->integer('total_amount')->comment('合計金額(税込み)');
            $table->boolean('account_discount_flag')->default(false)->comment('会計割引FLAG');
            $table->integer('account_discount_amount')->comment('会計割引金額');
            $table->integer('account_amount')->comment('会計金額');
            $table->unsignedBigInteger('account_method_id')->nullable()->comment('会計方法名ID');
            $table->dateTime('accounted_at')->nullable()->comment('会計時刻');
            $table->boolean('accounted_flag')->default(false)->comment('会計完了FLAG');
            $table->timestamps();
            $table->softDeletes();

            // スタッフテーブル
            $table->foreign('staff_id')->references('id')->on('staffs');
            // 店舗テーブル
            $table->foreign('store_id')->references('id')->on('stores');
            // 会計方法テーブル
            $table->foreign('account_method_id')->references('id')->on('account_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
