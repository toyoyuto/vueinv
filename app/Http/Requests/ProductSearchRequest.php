<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends BaseRequest
{
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
