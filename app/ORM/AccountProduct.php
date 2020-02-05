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
        'product_amount',
        'discount_id',
        'product_discount_amount',
        'consumption_tax_rate',
        'consumption_tax_amount',
    ];
}
