<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        \App\Models\Product::factory(2)->create([
            'name' => str()->random(10),
            'description' => str()->random(25),
        ]);
    }
}
