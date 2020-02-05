<?php

use Illuminate\Database\Seeder;
use App\Imports\ConsumptionTaxImport;
use App\ORM\ConsumptionTax;
use Maatwebsite\Excel\Facades\Excel;

class ConsumptionTaxsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ConsumptionTax::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $file_name = "database/seeds/data/consumption_tax.xlsx";
        Excel::import(new ConsumptionTaxImport, $file_name);
    }
}
