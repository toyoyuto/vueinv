<?php

use Illuminate\Database\Seeder;

class AccountProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        use SoftDeletes;

        /**
         * モデルと関連しているテーブル
         *
         * @var string
         */
        protected $table = 'account_methods';
    
        protected $fillable = [
            'name',
        ];
    }
}
