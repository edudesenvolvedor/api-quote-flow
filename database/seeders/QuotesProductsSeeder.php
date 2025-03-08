<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuotesProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quotes = Quote::factory()->count(100)->create();
        $products = Product::factory()->count(200)->create();

        $quotes->each(function ($quote) use ($products) {
            $quote->products()->attach(
                $products->random(rand(1, 5))->pluck('id')
            );
        });
    }
}
