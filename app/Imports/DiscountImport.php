<?php

namespace App\Imports;

use App\ORM\Discount;
use Maatwebsite\Excel\Concerns\ToModel;

class DiscountImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Discount([
            //
        ]);
    }
}
