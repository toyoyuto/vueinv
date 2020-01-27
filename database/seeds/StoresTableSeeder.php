<?php

use Illuminate\Database\Seeder;
use App\Imports\StoreImport;
use Maatwebsite\Excel\Facades\Excel;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_name = "database/seeds/data/store.xlsx";
        Excel::import(new StoreImport, $file_name);
    }
}
