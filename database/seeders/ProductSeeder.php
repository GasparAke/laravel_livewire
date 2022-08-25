<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'XIAOMI',
            'cost' => 300,
            'price' => 400,
            'barcode' => '75102715',
            'stock' => 500,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png',
        ]);
        Product::create([
            'name' => 'Nike',
            'cost' => 330,
            'price' => 450,
            'barcode' => '72362715',
            'stock' => 500,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curo.png',
        ]);
        Product::create([
            'name' => 'NIKE',
            'cost' => 340,
            'price' => 500,
            'barcode' => '75245715',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 2,
            'image' => 'crso.png',
        ]);
        Product::create([
            'name' => 'HP',
            'cost' => 500,
            'price' => 700,
            'barcode' => '712302715',
            'stock' => 300,
            'alerts' => 10,
            'category_id' => 3,
            'image' => 'cso.png',
        ]);
    }
}
