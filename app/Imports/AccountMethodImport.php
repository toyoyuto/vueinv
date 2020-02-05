<?php

namespace App\Imports;

use App\ORM\AccountMethod;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountMethodImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new  AccountMethod([
            'id' => $row['id'],
            'name' => $row['name'],
        ]);
    }
}
