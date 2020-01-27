<?php

namespace App\Imports;

use App\ORM\AccountMethod;
use Maatwebsite\Excel\Concerns\ToModel;

class AccountMethodImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AccountMethod([
            //
        ]);
    }
}
