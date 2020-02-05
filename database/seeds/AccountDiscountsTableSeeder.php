<?php

use Illuminate\Database\Seeder;
use App\ORM\Account;
use App\ORM\AccountDiscount;

class AccountDiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AccountDiscount::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // 割引が行われたデータを取得
        $account_records = Account::where('account_discount_amount', '>', 0)->get();
        
        $insert_data = [];
        $now         = now();

        foreach ($account_records as $account_record) {
            $customer_types = $this->faker->randomElements($values, $this->faker->numberBetween(1, count($values)));

            foreach ($customer_types as $customer_type) {
                $row                       = [];
                $row['announce_id']        = $announce_id;
                $row['BIG_KBN_CD']         = $big_kbn_customer_type;
                $row['MID_KBN_CD']         = $customer_type;
                $row['created_by']         = 'seeder';
                $row['updated_by']         = 'seeder';
                $row['created_at']         = $now;
                $row['updated_at']         = $now;
                $insert_data[]             = $row;
            }
        }

        foreach (array_chunk($insert_data, 1000) as $chunk) {
            (new AnnounceTarget())->insert($chunk);
        }
    }
}
