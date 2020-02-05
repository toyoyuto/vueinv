<?php

namespace App\Imports;

use App\ORM\Discount;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DiscountImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Discount([
            'discount_type' => $row['discount_type'],
            'name' => $row['name'],
        ]);
    }
}
