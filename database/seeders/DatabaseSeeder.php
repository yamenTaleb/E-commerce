<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CustomerSupport;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\shipment;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\WishList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();
         Product::factory(20)->create();
         Category::factory(10)->create();
         ProductImage::factory(20)->create();
         Cart::factory(10)->create();
         WishList::factory(10)->create();
         Shipment::factory(10)->create();
         Order::factory(10)->create();
         OrderDetail::factory(10)->create();
         Review::factory(10)->create();
         CustomerSupport::factory(10)->create();
         Coupon::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'yamen@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
