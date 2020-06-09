<?php

use App\Category;
use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class category_product_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $products = Product::all(); //return une collection! 
        
        $categories = DB::table('categories')->select('id')->get();
        foreach ($products as $product) {
            $product->categories()->attach([$categories->random()->id, $categories->random()->id]);
        }
        
    }
}
