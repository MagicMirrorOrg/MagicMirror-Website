<?php

use Illuminate\Database\Seeder;
use MagicMirror\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            "Utilities", 
            "System",
            "Transport",
            "Productivity",
            "Education",
            "Health",
            "Entertainment",
            "Fun & Games",
            "Sport"
        ];

        collect($categories)->each(function($item) {
            Category::create(['name' => $item]);
        });
    }
}
