<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    DB::table('items')->insert([
    'name' => 'Espresso',
    'description' => 'Classic single shot of espresso.',
    'price' => 25.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20133945.png'
]);
DB::table('items')->insert([
    'name' => 'Double Espresso',
    'description' => 'Double shot of espresso.',
    'price' => 35.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20134037.png'
]);

DB::table('items')->insert([
    'name' => 'Cappuccino',
    'description' => 'Espresso with steamed milk and foam.',
    'price' => 32.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20154228.png'
]);

DB::table('items')->insert([
    'name' => 'Latte',
    'description' => 'Espresso with steamed milk.',
    'price' => 32.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20154328.png'
]);

DB::table('items')->insert([
    'name' => 'Flat White',
    'description' => 'Smooth espresso with microfoam.',
    'price' => 33.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20154403.png'
]);

DB::table('items')->insert([
    'name' => 'Mocha',
    'description' => 'Espresso with chocolate and milk.',
    'price' => 35.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20154525.png'
]);

DB::table('items')->insert([
    'name' => 'Hot Chocolate',
    'description' => 'Rich and creamy hot chocolate.',
    'price' => 30.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20154619.png'
]);


DB::table('items')->insert([
    'name' => 'Tea',
    'description' => 'Selection of black, green, or herbal tea.',
    'price' => 18.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20155616.png'
]);

DB::table('items')->insert([
    'name' => 'Turkish Coffee',
    'description' => 'Traditional Turkish coffee.',
    'price' => 25.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20155845.png'
]);

DB::table('items')->insert([
    'name' => 'Iced Americano',
    'description' => 'Chilled espresso with water.',
    'price' => 30.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20155938.png'
]);

DB::table('items')->insert([
    'name' => 'Iced Latte',
    'description' => 'Cold espresso with milk.',
    'price' => 32.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20160014.png'
]);

DB::table('items')->insert([
    'name' => 'Iced Mocha',
    'description' => 'Chilled chocolate espresso with milk.',
    'price' => 35.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20160054.png'
]);

DB::table('items')->insert([
    'name' => 'Cold Brew',
    'description' => 'Slow brewed cold coffee.',
    'price' => 33.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20160204.png'
]);

DB::table('items')->insert([
    'name' => 'Lemon Iced Tea',
    'description' => 'Refreshing iced tea with lemon.',
    'price' => 28.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20160406.png'
]);

DB::table('items')->insert([
    'name' => 'Milkshake',
    'description' => 'Vanilla, Chocolate, or Strawberry shake.',
    'price' => 32.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20160459.png'
]);

DB::table('items')->insert([
    'name' => 'Fresh Orange Juice',
    'description' => 'Freshly squeezed orange juice.',
    'price' => 30.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20160553.png'
]);

DB::table('items')->insert([
    'name' => 'Cheesecake',
    'description' => 'Blueberry, Strawberry, or Lotus topping.',
    'price' => 45.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20161557.png'
]);

DB::table('items')->insert([
    'name' => 'Chocolate Cake',
    'description' => 'Rich layered chocolate cake.',
    'price' => 40.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20161625.png'
]);

DB::table('items')->insert([
    'name' => 'Muffins',
    'description' => 'Chocolate or Blueberry muffins.',
    'price' => 20.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20161659.png'
]);

DB::table('items')->insert([
    'name' => 'Croissant',
    'description' => 'Butter, Chocolate, or Cheese croissant.',
    'price' => 18.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20161724.png'
]);

DB::table('items')->insert([
    'name' => 'Donuts',
    'description' => 'Classic glazed donuts.',
    'price' => 15.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20161749.png'
]);

DB::table('items')->insert([
    'name' => 'Chicken Panini',
    'description' => 'Grilled chicken panini sandwich.',
    'price' => 40.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20161818.png'
]);

DB::table('items')->insert([
    'name' => 'Turkey & Cheese Sandwich',
    'description' => 'Turkey and cheese sandwich.',
    'price' => 38.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20161849.png'
]);

DB::table('items')->insert([
    'name' => 'Tuna Sandwich',
    'description' => 'Tuna mixed sandwich.',
    'price' => 35.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20161936.png'
]);

DB::table('items')->insert([
    'name' => 'Club Sandwich',
    'description' => 'Triple layered club sandwich.',
    'price' => 42.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20162147.png'
]);

DB::table('items')->insert([
    'name' => 'Grilled Cheese Sandwich',
    'description' => 'Grilled melted cheese sandwich.',
    'price' => 30.0,
    'image_url' => 'http://localhost:8000/storage/items/Screenshot%202025-07-05%20162207.png'
]);
  }
}
