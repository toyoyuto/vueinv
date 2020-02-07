<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountProduct extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'account_products';

    protected $fillable = [
        'account_id',
        'product_id',
        'without_tax_sell_price',
        'discount_id',
        'product_discount_amount',
        'consumption_tax_rate',
        'account_product_amount',
    ];
}
