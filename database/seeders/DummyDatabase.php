<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MainProduct;
use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryMerchandise;
use App\Models\UserDetail;
use App\Models\VersionProduct;
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
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        $user_detail = new UserDetail();
        $user_detail->user_id = $user->id;
        $user_detail->save();
    }

    private function insertMainProducts(String $name, String $category, String $group, String $merchandise, array $version){
        $product = new MainProduct();
        $product->product_name = $name;
        $product->product_category = $category;
        $product->category_group_id = $this->getGroupID($group);
        $product->category_merchandise_id = $this->getMerchandiseID($merchandise);
        $product->save();

        foreach($version as $eachVersion){
            $version = new VersionProduct();
            $version->version_name = $eachVersion[0];
            $version->main_product_id = $product->id;
            $version->version_stock = $eachVersion[1];
            $version->version_price = $eachVersion[2];
            $version->version_price_created =$eachVersion[2];
            $version->save();
        }
    }

    private function insertCategoryGroup(String $name){
        $group = new CategoryGroup();
        $group->group_name = $name;
        $group->save();
    }

    private function insertCategoryMerchandise(String $name){
        $group = new CategoryMerchandise();
        $group->merchandise_name = $name;
        $group->save();
    }


    public function run()
    {
        // \App\Models\User::factory(5)->create();
        $this->insertUser('fdh@gmail.com', 'Nda', 'admin');

        $this->insertCategoryGroup('Monsta X');
        $this->insertCategoryGroup('GOT7');
        $this->insertCategoryGroup('DAY6');
        $this->insertCategoryMerchandise('Album');
        $this->insertCategoryMerchandise('Lightstick');
        $this->insertCategoryMerchandise('Season Greeting');

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
