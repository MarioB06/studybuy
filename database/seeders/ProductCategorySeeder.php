<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'icon' => 'fas fa-laptop',
            ],
            [
                'name' => 'Bücher',
                'icon' => 'fas fa-book',
            ],
            [
                'name' => 'Rechner',
                'icon' => 'fas fa-calculator',
            ],
            [
                'name' => 'Zubehör',
                'icon' => 'fas fa-backpack',
            ],
            [
                'name' => 'Möbel',
                'icon' => 'fas fa-couch',
            ],
            [
                'name' => 'Kleidung',
                'icon' => 'fas fa-shirt',
            ],
            [
                'name' => 'Sport',
                'icon' => 'fas fa-dumbbell',
            ],
            [
                'name' => 'Sonstiges',
                'icon' => 'fas fa-box',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::updateOrCreate(
                ['name' => $category['name']],
                ['icon' => $category['icon']]
            );
        }
    }
}
