<?php

namespace App\Imports;

use App\ORM\ConsumptionTax;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConsumptionTaxImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ConsumptionTax([
            'id' => $row['id'],
            'rate' => $row['rate'],
        ]);
    }
}
