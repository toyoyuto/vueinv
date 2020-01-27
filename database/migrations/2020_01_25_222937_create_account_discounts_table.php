<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id')->comment('会計ID');
            $table->unsignedBigInteger('discount_id')->comment('割引ID');
            $table->integer('discount_amount')->comment('割引金額');
            $table->timestamps();
            $table->softDeletes();

            // 会計テーブル
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('account_discounts');
    }
}
