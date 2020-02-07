<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountDiscount extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'account_discounts';

    protected $fillable = [
        'account_id',
        'discount_id',
        'discount_amount',
    ];
}
