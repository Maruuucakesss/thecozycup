<?php
namespace Database\Seeders;
use App\Models\{Category, Option, Product, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default admin. Change the password in Admin > Password after first login.
        User::create(['name'=>'Admin','email'=>'admin@thecozycup.com','password'=>Hash::make('Admin@123'),'role'=>'admin']);
        foreach (['Coffee'=>'coffee','Non-Coffee'=>'non-coffee','Pastries'=>'pastries'] as $n=>$s) Category::create(['name'=>$n,'slug'=>$s]);
        $drinks = [
            [1,'Americano - Unsweetened','Bold espresso and water, no sugar.',80,80,0],
            [1,'Americano - Sweetened','Espresso and water with a touch of sweetness.',90,90,0],
            [1,'Latte','Smooth espresso with steamed milk.',100,110,0],
            [1,'Caramel Macchiato','Vanilla, milk, espresso and caramel.',130,130,1],
            [1,'Dirty Matcha','Matcha latte topped with an espresso shot.',130,140,0],
            [1,'Seasalt Latte','Espresso latte with a salty-sweet cream top.',120,140,1],
            [1,'Spanish Latte','Espresso and milk sweetened with condensed milk.',110,120,1],
            [1,'Hazelnut Latte','Nutty hazelnut syrup in a creamy latte.',110,120,0],
            [1,'Vanilla Oat Latte','Vanilla and oat milk with espresso.',130,140,0],
            [1,'Mocha Latte','Espresso, chocolate and milk.',120,140,0],
            [2,'Oat Matcha Latte','Ceremonial-style matcha with oat milk.',140,150,0],
            [2,'Matcha Latte','Earthy matcha with creamy milk.',120,130,1],
            [2,'Seasalt Matcha','Matcha latte with a seasalt cream top.',130,140,0],
        ];
        foreach ($drinks as [$c,$n,$d,$cold,$hot,$f])
            Product::create(['category_id'=>$c,'name'=>$n,'description'=>$d,'is_drink'=>true,'price_cold'=>$cold,'price_hot'=>$hot,'featured'=>(bool)$f]);
        $foods = [
            ['Butter Croissant','Flaky and buttery, baked fresh.',75],['Chocolate Chip Cookie','Soft and chewy with melty chips.',45],
            ['Banana Bread','Moist slice with ripe banana.',60],['Blueberry Muffin','Tender muffin with blueberries.',70],
            ['Ensaymada','Soft sweet bun with butter and cheese.',55],['Fudgy Brownie','Rich chocolate brownie square.',65],
        ];
        foreach ($foods as [$n,$d,$p]) Product::create(['category_id'=>3,'name'=>$n,'description'=>$d,'is_drink'=>false,'price'=>$p]);
        $opts = [['Sugar level','Regular',0,0],['Sugar level','Less sugar',0,0],['Sugar level','No sugar',0,0],
                 ['Extras','Extra shot',30,1],['Extras','Oat milk',30,1],['Extras','Vanilla syrup',20,1],['Extras','Caramel drizzle',20,1]];
        foreach ($opts as $i => [$g,$n,$p,$m]) Option::create(['grp'=>$g,'name'=>$n,'price_add'=>$p,'is_multi'=>(bool)$m,'sort'=>$i+1]);
    }
}
