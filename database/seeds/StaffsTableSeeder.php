<?php

use Illuminate\Database\Seeder;
use App\Imports\StaffImport;
use Maatwebsite\Excel\Facades\Excel;

class StaffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_name = "database/seeds/data/staff.xlsx";
        Excel::import(new StaffImport, $file_name);
    }
}
