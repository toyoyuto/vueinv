<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // マスタ系
        $this->call(StoresTableSeeder::class);
        $this->call(StaffsTableSeeder::class);
        $this->call(AccountMethodsTableSeeder::class);
        $this->call(ConsumptionTaxsTableSeeder::class);
        $this->call(DiscountsTableSeeder::class);
        $this->call(ProductCategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        
        // テスト系
        $this->call(AccountsTableSeeder::class);
    }
}
