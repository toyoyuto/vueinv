<?php

namespace App\Imports;

use App\ORM\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductCategoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProductCategory([
            //
        ]);
    }
}
