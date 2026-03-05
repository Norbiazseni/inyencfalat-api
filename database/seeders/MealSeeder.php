<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\Meal;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = Ingredient::all();
        Meal::factory()->count(5)->create()->each(function ($meal) use ($ingredients) {
            $meal->ingredients()->attach($ingredients->random(rand(1, 5))->pluck('id')->toArray());
        });
    }
}
