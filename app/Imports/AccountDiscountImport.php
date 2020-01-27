<?php

namespace App\Imports;

use App\ORM\AccountDiscount;
use Maatwebsite\Excel\Concerns\ToModel;

class AccountDiscountImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AccountDiscount([
            //
        ]);
    }
}
