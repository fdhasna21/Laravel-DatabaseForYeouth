<?php

namespace Database\Seeders;

use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryMerchandise;
use App\Models\MainProduct;
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

    private function insertMainProducts(String $name, String $category, String $group, String $merchandise, array $version){
        DB::table('main_products')->insert([
            'product_name' => $name,
            'product_category' => $category,
            'category_group_id' => $this->getGroupID($group),
            'category_merchandise_id' => $this->getMerchandiseID($merchandise)
        ]);

        $product_id = MainProduct::where('product_name', '=', $name)->value('id');

        foreach($version as $version_name){
            DB::table('version_products')->insert([
            'version_name' => $version_name,
            'main_product_id' => $product_id
        ]);
        }

    }


    public function run()
    {
        // DB::table('users')->delete();
        // DB::table('version_products')->delete();
        // DB::table('main_products')->delete();
        // DB::table('category_groups')->delete();
        // DB::table('category_merchandises')->delete();

        // // \App\Models\User::factory(5)->create();
        // DB::table('users')->insert([
        //     'name' => 'Nda',
        //     'email' => 'fdh@gmail.com',
        //     'password' => Hash::make('admin'),
        //     'created_at' => now()
        // ]);

        // DB::table('category_groups')->insert(['group_name' => 'Monsta X']);
        // DB::table('category_groups')->insert(['group_name' => 'GOT7']);
        // DB::table('category_groups')->insert(['group_name' => 'DAY6']);

        // DB::table('category_merchandises')->insert(['merchandise_name' => 'Album']);
        // DB::table('category_merchandises')->insert(['merchandise_name' => 'Lightstick']);
        // DB::table('category_merchandises')->insert(['merchandise_name' => 'Season Greeting']);

        $this->insertMainProducts('The Book of Us: Negentropy - Chaos swallowed up in love',
            '7th Korean Mini-Album', 'DAY6', 'Album', array('One& ver.', 'Only ver.'));

        $this->insertMainProducts('The Book of Us : Entropy',
           '3rd Korean Studio Album', 'DAY6', 'Album', array('Sweet ver.', 'Chaos ver.'));

        $this->insertMainProducts('DAY6 Official Lightband',
            'Official Concert Light Stick', 'DAY6', 'Lightstick', array('ver 1', 'ver 2'));

        $this->insertMainProducts('Fantasia X',
            '8th Korean Mini-Album', 'MONSTA X', 'Album', array('ver.1', 'ver.2', 'ver.3', 'ver.4'));

        $this->insertMainProducts('All About Luv',
           '1st English Studio Album', 'MONSTA X', 'Album', array('ver.1', 'ver.2', 'ver.3', 'ver.4'));

        $this->insertMainProducts('MONSTA X Official Light Stick',
            'Official Concert Light Stick', 'MONSTA X', 'Lightstick', array('ver 1', 'ver 2'));
    }
}
