<?php

namespace App\Imports;

use App\ORM\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'id' => $row['id'],
            'product_cd' => $row['product_cd'],
            'name' => $row['name'],
            'product_category_id' => $row['product_category_id'],
            'without_tax_sell_price' => $row['without_tax_sell_price'],
        ]);
    }
}
