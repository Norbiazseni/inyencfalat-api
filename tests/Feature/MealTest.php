<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Meal;
use App\Models\Ingredient;

class MealTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_all_meals(): void
    {
        //arrange

        $ingredients = Ingredient::factory()->count(10)->create();
        $meals = Meal::factory()->count(5)->create()->each(function ($meal) use ($ingredients) {
            $meal->ingredients()->attach(
                $ingredients->pluck('id')
            );
        });

        //act
        $response = $this->getJson('/api/meals');

        //assert
        $response->assertStatus(200);
        $this->assertGreaterThan(0, count($response->json()));
    }
}
