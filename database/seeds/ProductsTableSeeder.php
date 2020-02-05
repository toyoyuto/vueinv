<?php

use Illuminate\Database\Seeder;
use App\Imports\ProductImport;
use App\ORM\Product;
use Maatwebsite\Excel\Facades\Excel;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file_name = "database/seeds/data/product.xlsx";
        Excel::import(new ProductImport, $file_name);
    }
}
