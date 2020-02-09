<?php

use Illuminate\Database\Seeder;
use App\Constants\Constants;
use App\ORM\Account;
use App\ORM\Store;
use App\ORM\Staff;
use App\ORM\Product;
use App\ORM\ConsumptionTax;
use App\ORM\AccountMethod;
use App\ORM\AccountProduct;
use App\ORM\Discount;
use App\ORM\AccountDiscount;

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
        AccountProduct::truncate();
        AccountDiscount::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $store_ids = Store::get()->pluck('id')->toArray();
        $staff_ids = Staff::get()->pluck('id')->toArray();
        $account_method_ids = AccountMethod::get()->pluck('id')->toArray();

        // 会計、商品会計用割引データ
        $discount_ids = Discount::get()->groupBy('discount_type');
        // 会計に対しての割り引きデータを取得
        $account_discount_ids = $discount_ids[1]->pluck('id')->toArray();
        // 商品に対しての割り引きデータを取得
        $product_discount_ids = $discount_ids[2]->pluck('id')->toArray();

        // 消費税データ
        $consumption_tax_rates = ConsumptionTax::orderBy('rate')->get()->pluck('rate')->toArray();
        // 商品データ
        $product_records = Product::with('productCategory.consumptionTax')->get();

        // 現在時刻
        $now = now();

        for ($cnt = 1; $cnt <= 100; $cnt++) {
            Log::info("${cnt}回目");
            // 商品数
            $product_count = $this->faker->numberBetween(1, 10);

            // 購入商品
            // NOTE: ランダム個数取得したいため一旦コレクションから配列に変換、再度コレクションに戻す
            $account_products = collect($this->faker->randomElements($product_records->all() , $product_count, true));

            // 会計商品一括登録用
            $account_product_insert_data = [];

             // 会計データ
            $account_object = new stdClass();
            $account_object->tax_amount_1_product_amount = 0;
            $account_object->tax_amount_2_product_amount = 0;

            $account_product_insert_data = [];
            
            // 金額の差異がないようにaccount_productのデータもここで入れる
            $account_products->map(function ($account_product, $key) use(&$account_object, &$account_product_insert_data, $product_discount_ids, $now, $consumption_tax_rates) {
                $this->makeAccountproducts($account_product, $account_object, $account_product_insert_data, $product_discount_ids, $now, $consumption_tax_rates);
            });

            // 商品の金額計算
            // 商品金額合計(税抜き)
            $account_object->total_product_amount =
                $account_object->tax_amount_1_product_amount + $account_object->tax_amount_2_product_amount;
            // 消費税
            $account_object->tax_amount_1=
                round($account_object->tax_amount_1_product_amount* ($consumption_tax_rates[0] * 0.01));
            $account_object->tax_amount_2 =
                round($account_object->tax_amount_2_product_amount * ($consumption_tax_rates[1] * 0.01));
            $account_object->total_tax_amount =
                $account_object->tax_amount_1 + $account_object->tax_amount_2;

            // 会計済みフラグが立っていれば,会計時刻と会計方法を入力
            $account_method_object = new stdClass();
            $account_method_object->accounted_at = null;
            $account_method_object->account_method_id = null;
            $account_method_object->account_flag = $this->faker->randomElement(Constants::AccountFlag);

            if ($account_method_object->account_flag == Constants::AccountFlag['paid']) {
                $account_method_object->accounted_at = $now;
                $account_method_object->account_method_id = $this->faker->randomElement($account_method_ids);
            }
            // 割引を行うか
            $account_discount_object = new stdClass();
            $account_discount_object->account_discount_amount = 0;
            $account_discount_object->account_discount_flag = false;
            $account_discount_object->account_discount_id = null;
            if ($this->faker->boolean(20)) {
                $account_discount_object->account_discount_flag = true;
                $account_discount_object->account_discount_amount =
                    $this->faker->numberBetween(0, $account_object->total_product_amount + $account_object->total_tax_amount);
                $account_discount_object->account_discount_id =
                    $this->faker->randomElement($account_discount_ids);
            }
      
            // 会計商品登録
            $accunt =
                $this->insertAccount($staff_ids, $store_ids, $now, $account_object, $account_method_object, $account_discount_object);

            foreach($account_product_insert_data as &$account_product_data){
                $account_product_data['account_id'] = $accunt->id;
            }
            // 会計商品登録
            AccountProduct::insert($account_product_insert_data);
            // 会計割引登録
            if ($account_discount_object->account_discount_id) {
                $this->insertAccountDiscount($accunt->id, $account_discount_object, $now);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function makeAccountproducts($account_product, &$account_object, &$account_product_insert_data, $product_discount_ids, $now, $consumption_tax_rates)
    {
        // 割引されるか判定
        $product_discount_id = null;
        $product_discount_amount = 0;
        if ($this->faker->boolean(20)) {
            $product_discount_id = $this->faker->randomElement($product_discount_ids);
            $product_discount_amount = $this->faker->numberBetween(0, $account_product->without_tax_sell_price);
        }
        // 消費税率
        $tax_rate = 0.01 * $account_product->productCategory->consumptionTax->rate;

        $account_product_row  = [];
        $account_product_row['product_id'] = $account_product->id;
        $account_product_row['without_tax_sell_price'] = $account_product->without_tax_sell_price;
        $account_product_row['discount_id'] = $product_discount_id;
        $account_product_row['product_discount_amount'] = $product_discount_amount;
        $account_product_row['account_product_amount'] = $account_product_row['without_tax_sell_price'] - $account_product_row['product_discount_amount'];
        $account_product_row['consumption_tax_rate'] = $account_product->productCategory->consumptionTax->rate;
        $account_product_row['created_at'] = $now;
        $account_product_row['updated_at'] = $now;
        $account_product_insert_data[] = $account_product_row;

        // 会計データに入れるため商品の金額を足していく(上は8,下は10)
        // TODO: 消費税は個別ではなく、全体から計算する
        If ($account_product->productCategory->consumptionTax->rate == $consumption_tax_rates[0]){
            $account_object->tax_amount_1_product_amount += $account_product_row['account_product_amount']; 
        } else {
            $account_object->tax_amount_2_product_amount += $account_product_row['account_product_amount'];
        }
    }

    /**
     * Run the database seeds.
     *
     * @return $accuntnt
     */
    public function insertAccount($staff_ids, $store_ids, $now, $account_object, $account_method_object, $account_discount_object)
    {
        $account_data = [];
        $account_data['staff_id'] = $this->faker->randomElement($staff_ids);
        $account_data['store_id'] = $this->faker->randomElement($store_ids);
        $account_data['total_product_amount'] = $account_object->total_product_amount;
        $account_data['tax_amount_1_product_amount'] = $account_object->tax_amount_1_product_amount;
        $account_data['tax_amount_1'] = $account_object->tax_amount_1;
        $account_data['tax_amount_2_product_amount'] = $account_object->tax_amount_2_product_amount;
        $account_data['tax_amount_2'] = $account_object->tax_amount_2;
        $account_data['total_tax_amount'] = $account_object->total_tax_amount;
        $account_data['total_amount'] = $account_object->total_product_amount + $account_object->total_tax_amount;
        $account_data['account_discount_flag'] =  $account_discount_object->account_discount_flag;
        $account_data['account_discount_amount'] =  $account_discount_object->account_discount_amount;
        $account_data['account_amount'] = $account_data['total_amount'] - $account_data['account_discount_amount'];
        $account_data['account_method_id'] = $account_method_object->account_method_id;
        $account_data['accounted_at'] = $account_method_object->accounted_at;
        $account_data['accounted_flag'] = $account_method_object->account_flag;
        $account_data['created_at'] = $now;
        $account_data['updated_at'] = $now;
        $accunt = Account::create($account_data);
        return $accunt;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function insertAccountDiscount($account_id, $account_discount_object, $now)
    {
        $account_discount_insert_data = [];

        $account_discount_row  = [];
        $account_discount_row['account_id'] = $account_id;
        $account_discount_row['discount_id'] = $account_discount_object->account_discount_id;
        $account_discount_row['discount_amount'] = $account_discount_object->account_discount_amount;
        $account_discount_row['created_at'] = $now;
        $account_discount_row['updated_at'] = $now;
        $account_discount_insert_data[] = $account_discount_row;
        // 会計割引
        AccountDiscount::insert($account_discount_insert_data);
    }

}
