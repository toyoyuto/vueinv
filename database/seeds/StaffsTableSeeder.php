<?php

use Illuminate\Database\Seeder;
use App\Imports\StaffImport;
use App\ORM\Staff;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Staff::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file_name = "database/seeds/data/staff.xlsx";
        Excel::import(new StaffImport, $file_name);
    }
}
