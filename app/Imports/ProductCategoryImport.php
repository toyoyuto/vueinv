<?php

namespace App\Imports;

use App\ORM\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductCategoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProductCategory([
            'id' => $row['id'],
            'name' => $row['name'],
            'consumption_tax_id' => $row['consumption_tax_id'],
        ]);
    }
}
