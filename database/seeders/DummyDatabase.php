<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MainProduct;
use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryMerchandise;
use Illuminate\Support\Facades\Hash;

class DummyDatabase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private function getGroupID(String $group){
        return CategoryGroup::select('id')->where('group_name', 'LIKE', "%$group%")->value('id');
    }

    private function getMerchandiseID(String $merchandise){
        return CategoryMerchandise::select('id')->where('merchandise_name', 'LIKE', "%$merchandise%")->value('id');
    }

    private function insertUser(String $email, String $name, String $password){
        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'created_at' => now()
        ]);

        $user_id = User::where('email', '=', $email)->value('id');

        DB::table('user_details')->insert([
            'user_id' => $user_id
        ]);
    }

    private function insertMainProducts(String $name, String $category, String $group, String $merchandise, array $version){
        DB::table('main_products')->insert([
            'product_name' => $name,
            'product_category' => $category,
            'category_group_id' => $this->getGroupID($group),
            'category_merchandise_id' => $this->getMerchandiseID($merchandise)
        ]);

        $product_id = MainProduct::where('product_name', '=', $name)->value('id');

        foreach($version as $eachVersion){
            DB::table('version_products')->insert([
            'version_name' => $eachVersion[0],
            'main_product_id' => $product_id,
            'version_stock' => $eachVersion[1],
            'version_price' => $eachVersion[2],
            'version_price_created' => $eachVersion[2]
        ]);
        }
    }


    public function run()
    {
        DB::table('users')->delete();
        DB::table('version_products')->delete();
        DB::table('main_products')->delete();
        DB::table('category_groups')->delete();
        DB::table('category_merchandises')->delete();

        // \App\Models\User::factory(5)->create();
        $this->insertUser('fdh@gmail.com', 'Nda', 'admin');

        DB::table('category_groups')->insert(['group_name' => 'Monsta X']);
        DB::table('category_groups')->insert(['group_name' => 'GOT7']);
        DB::table('category_groups')->insert(['group_name' => 'DAY6']);

        DB::table('category_merchandises')->insert(['merchandise_name' => 'Album']);
        DB::table('category_merchandises')->insert(['merchandise_name' => 'Lightstick']);
        DB::table('category_merchandises')->insert(['merchandise_name' => 'Season Greeting']);

        $this->insertMainProducts('The Book of Us: Negentropy - Chaos swallowed up in love',
            '7th Korean Mini-Album', 'DAY6', 'Album', array(['One& ver.', 10, 250000], ['Only ver.', 20, 250000]));

        $this->insertMainProducts('The Book of Us : Entropy',
           '3rd Korean Studio Album', 'DAY6', 'Album', array(['Sweet ver.', 50, 300000], ['Chaos ver.', 25, 300000]));

        $this->insertMainProducts('DAY6 Official Lightband',
            'Official Concert Light Stick', 'DAY6', 'Lightstick', array(['ver 1', 40, 270000], ['ver 2', 35, 270000]));

        $this->insertMainProducts('Fantasia X',
            '8th Korean Mini-Album', 'MONSTA X', 'Album', array(['ver.1', 30, 320000], ['ver.2', 30, 320000], ['ver.3', 35, 320000], ['ver.4', 20, 320000]));

        $this->insertMainProducts('All About Luv',
           '1st English Studio Album', 'MONSTA X', 'Album', array(['ver.1', 15, 350000], ['ver.2', 10, 350000], ['ver.3', 15, 350000], ['ver.4', 25, 350000]));

        $this->insertMainProducts('MONSTA X Official Light Stick',
            'Official Concert Light Stick', 'MONSTA X', 'Lightstick', array(['ver 1', 65, 370000], ['ver 2', 60, 370000]));
    }
}
