<?php

namespace App\Imports;

use App\ORM\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Staff([
            'id' => $row['id'],
            'staff_cd' => $row['staff_cd'],
            'name' => $row['name'],
            'email' => $row['email'],
        ]);
    }
}
