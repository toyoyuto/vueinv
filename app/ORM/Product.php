<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'product_cd',
        'name',
        'product_category_id',
        'without_tax_sell_price',
    ];

    /**
     * 商品→商品カテゴリを取得
     *
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
