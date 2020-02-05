<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'product_categories';

    protected $fillable = [
        'name', 
        'consumption_tax_id', 
    ];

    /**
     * 商品カテゴリ→消費税取得
     *
     */
    public function consumptionTax()
    {
        return $this->belongsTo(ConsumptionTax::class);
    }
}
