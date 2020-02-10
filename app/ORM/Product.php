<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @SWG\Definition(
 *     definition="product", 
 *     type="object", 
 *     @SWG\Property(property="id",description="ID", type="integer"),
 *     @SWG\Property(property="product_cd",description="商品CD", type="string"),
 *     @SWG\Property(property="name",description="商品名", type="string"),
 *     @SWG\Property(property="product_category_id",description="商品カテゴリーCD", type="integer"),
 *     @SWG\Property(property="without_tax_sell_price",description="販売単価(税抜き)", type="string")
 * )
 */

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
