<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @SWG\Definition(definition="ProductSearchRequest", type="object")
 */

class ProductSearchRequest extends BaseRequest
{
    /**
     * @SWG\Property(property="id",description="ID", type="integer")
     * @SWG\Property(property="product_cd",description="商品CD", type="string")
     * @SWG\Property(property="name",description="商品名", type="string")
     * @SWG\Property(property="product_category_id",description="商品カテゴリーCD", type="integer")
     * @SWG\Property(property="without_tax_sell_price",description="販売単価(税抜き)", type="string")
     */
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['nullable', 'integer'],
            'product_cd' => ['nullable', 'max:10'],
            'name' => ['nullable', 'max:255'],
            'product_category_id' => ['nullable', 'integer'],
            'without_tax_sell_price' => ['nullable', 'integer', 'max:11'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => '商品名',
        ];
    }
}
