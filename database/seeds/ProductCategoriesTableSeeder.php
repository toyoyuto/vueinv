<?php

use Illuminate\Database\Seeder;
use App\Imports\ProductCategoryImport;
use App\ORM\ProductCategory;
use Maatwebsite\Excel\Facades\Excel;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file_name = "database/seeds/data/product_category.xlsx";
        Excel::import(new ProductCategoryImport, $file_name);
    }
}
