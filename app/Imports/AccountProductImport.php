<?php

namespace App\Imports;

use App\ORM\AccountProduct;
use Maatwebsite\Excel\Concerns\ToModel;

class AccountProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AccountProduct([
            //
        ]);
    }
}
