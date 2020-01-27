<?php

namespace App\Imports;

use App\ORM\ConsumptionTax;
use Maatwebsite\Excel\Concerns\ToModel;

class ConsumptionTaxImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ConsumptionTax([
            //
        ]);
    }
}
