<?php

use Illuminate\Database\Seeder;
use App\Constants\Constants;
use App\ORM\Account;
use App\ORM\Store;
use App\ORM\Staff;
use App\ORM\Product;
use App\ORM\ConsumptionTax;
use App\ORM\ProductCategory;
use App\ORM\AccountMethod;
use App\ORM\AccountProduct;
use App\ORM\Discount;

class AccountsTableSeeder extends Seeder
{
    protected $faker;

    /**
     * GoodsCommentTableSeeder constructor.
     */
    public function __construct()
    {
        $this->faker = Faker\Factory::create('ja_JP');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::enableQueryLog();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Account::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 挿入用データ
        $store_ids = Store::get()->pluck('id')->toArray();
        $staff_ids = Staff::get()->pluck('id')->toArray();
        $account_method_ids = AccountMethod::get()->pluck('id')->toArray();

        //　計算用データ
        $product_category_ids = ProductCategory::get()->pluck('id')->toArray();
        $consumption_tax_records = ConsumptionTax::get()->pluck('id', 'rate')->toArray();
        $product_records = Product::with('productCategory.consumptionTax')->get();
        // 商品に対しての割り引きデータを取得
        $discount_ids = Discount::where('discount_type', 2)->get()->pluck('id')->toArray();

        $now = now();
        $insert_data　= [];
        $account_product_insert_data = [];
        for ($cnt = 1; $cnt <= 10; $cnt++) {
            Log::info("一回目${cnt}");
            // 会計済みフラグ
            $account_flag = $this->faker->randomElement(Constants::AccountFlag);
            // 商品数
            $product_count = $this->faker->numberBetween(1, 10);

            // 購入商品
            // NOTE: ランダム個数取得したいため一旦コレクションから配列に変換、再度コレクションに戻す
            $account_products = collect($this->faker->randomElements($product_records->all() , $product_count, true));

            // 商品の金額計算
            // 商品金額合計(税抜き)
            $total_product_amount = $account_products->sum('without_tax_sell_price');

            $row_data  = [];
            $row_data['tax_amount_1_product_amount'] = 0;
            $row_data['tax_amount_1'] = 0; 
            $row_data['tax_amount_2_product_amount'] = 0;
            $row_data['tax_amount_2'] = 0; 

            // 金額の差異がないようにaccount_productのデータもここで入れる
            $account_products->map(function ($account_product, $key) use(&$row_data, &$account_product_insert_data, $discount_ids, $now) {
                // 割引されるか判定
                $product_discount_id = null;
                $product_discount_amount = 0;
                if ($this->faker->boolean(20)) {
                    $product_discount_id = $this->faker->randomElement($discount_ids);
                    $product_discount_amount = $this->faker->numberBetween(0, $account_product->without_tax_sell_price);
                }
                // 消費税率
                $tax_rate = 0.01 * $account_product->productCategory->consumptionTax->rate;
                $account_product_row  = [];
                $account_product_row['product_id'] = $account_product->id;
                $account_product_row['product_amount'] = $account_product->without_tax_sell_price;
                $account_product_row['discount_id'] = $product_discount_id;
                $account_product_row['product_discount_amount'] = $product_discount_amount;
                $account_product_row['consumption_tax_rate'] = $account_product->productCategory->consumptionTax->rate;;
                $account_product_row['consumption_tax_amount'] = round($account_product->without_tax_sell_price * $tax_rate);
                $account_product_row['created_at'] = $now;
                $account_product_row['updated_at'] = $now;
                $account_product_insert_data[] = $account_product_row;

                // 会計データに入れるため商品の金額を足していく
                If ($account_product->productCategory->consumptionTax->rate == 8){
                    $row_data['tax_amount_1_product_amount'] += $account_product_row['product_amount']; 
                    $row_data['tax_amount_1'] += $account_product_row['consumption_tax_amount']; 
                } else {
                    $row_data['tax_amount_2_product_amount'] += $account_product_row['product_amount'];
                    $row_data['tax_amount_2'] += $account_product_row['consumption_tax_amount']; 
                }
            });
            // $group_products = $account_products->groupBy('productCategory.consumptionTax.rate');
       
            // $row_data  = [];
            // $row_data['tax_amount_1_product_amount'] = 0;
            // $row_data['tax_amount_1'] = 0; 
            // $row_data['tax_amount_2_product_amount'] = 0;
            // $row_data['tax_amount_2'] = 0; 
            // $group_products->map(function ($account_products, $key) use(&$row_data) {
            //     $tax_rate = 0.01 * $key;
            //     If ($key == 8){
            //         $row_data['tax_amount_1_product_amount'] = $account_products->sum('without_tax_sell_price'); 
            //         $row_data['tax_amount_1'] = round($account_products->sum('without_tax_sell_price') * $tax_rate); 
            //     } else {
            //         $row_data['tax_amount_2_product_amount'] = $account_products->sum('without_tax_sell_price');
            //         $row_data['tax_amount_2'] = round($account_products->sum('without_tax_sell_price') * $tax_rate); 
            //     }
            // });
            // 消費税の合計
            $row_data['total_tax_amount'] = $row_data['tax_amount_1'] + $row_data['tax_amount_2'];
            // $category1_products = $account_products->where('productCategory.consumptionTax.id', 1);
            // $category2_products = $account_products->where('productCategory.consumptionTax.id', 2);
            // // Log::debug('grouped');
            // // Log::debug($grouped->count());
            // // // 消費税毎にまとめる
            // // $category1_products = $account_products->filter(function ($value, $key) {
            // //     return $value->productCategory->consumptionTax->id == 1;
            // // });
            // // $category2_products = $account_products->filter(function ($value, $key) {
            // //     return $value->productCategory->consumptionTax->id == 2;
            // // });
            // $tax_amount_1_product_amount = $category1_products->sum('without_tax_sell_price'); 

            // $tax_amount_2_product_amount = $category2_products->sum('without_tax_sell_price'); 

            // 会計済みフラグが立っていれば,会計時刻と会計方法を入力
            $accounted_at = null;
            $account_method_id = null;
            if ($account_flag == Constants::AccountFlag['paid']) {
                $accounted_at = $now ;
                $account_method_id = $this->faker->randomElement($account_method_ids);
            }
            // 割引を行うか
            $account_discount_amount = 0;
            $account_discount_flag = false;
            if ($this->faker->boolean(20)) {
                $account_discount_flag = true;
                $account_discount_amount = $this->faker->numberBetween(0, $total_product_amount + $row_data['total_tax_amount']);
                // シーダーを呼ぶ
                //$this->call(AccountDiscountsTableSeeder::class);
            }
            $row  = [];
            $row['staff_id'] = $this->faker->randomElement($staff_ids);
            $row['store_id'] = $this->faker->randomElement($store_ids);
            $row['total_product_amount'] = $total_product_amount;
            $row['tax_amount_1_product_amount'] = $row_data['tax_amount_1_product_amount'];
            $row['tax_amount_1'] = $row_data['tax_amount_1'];
            $row['tax_amount_2_product_amount'] = $row_data['tax_amount_2_product_amount'];
            $row['tax_amount_2'] = $row_data['tax_amount_2'];
            $row['total_tax_amount'] = $row_data['total_tax_amount'];
            $row['total_amount'] = $total_product_amount + $row_data['total_tax_amount'];
            $row['account_discount_flag'] =  $account_discount_flag;
            $row['account_discount_amount'] =  $account_discount_amount;
            $row['account_amount'] = $row['total_amount'] - $row['account_discount_amount'];
            $row['account_method_id'] = $account_method_id;
            $row['accounted_at'] = $accounted_at;
            $row['accounted_flag'] = $account_flag;
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
            $insert_data[] = $row;
            $accunt = Account::create($row);

            foreach($account_product_insert_data as &$account_product_data){
                $account_product_data['account_id'] = $accunt->id;
            }
            AccountProduct::insert($account_product_insert_data);
        }
        // Account::insert($insert_data);
        // AccountProduct::insert($account_product_insert_data);
    }
}
