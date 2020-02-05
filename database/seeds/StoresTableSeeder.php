<?php

use Illuminate\Database\Seeder;
use App\Imports\StoreImport;
use App\ORM\ Store;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Store::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file_name = "database/seeds/data/store.xlsx";
        Excel::import(new StoreImport, $file_name);
    }
}
