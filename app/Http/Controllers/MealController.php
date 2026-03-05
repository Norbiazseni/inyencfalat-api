<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{

    public function index()
    {
        return response()->json(Meal::with('ingredients')->get(), 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'exists:ingredients,id'
        ]);

        $meal = Meal::create([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        $meal->ingredients()->attach($validated['ingredients']);

        return response()->json($meal->load('ingredients'), 201);
    }


    public function update(Request $request, $id)
    {
        $meal = Meal::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'exists:ingredients,id'
        ]);

        $meal->update([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        $meal->ingredients()->sync($validated['ingredients']);

        return response()->json($meal->load('ingredients'), 200);
    }

    public function search($ingredient)
    {
        $meals = Meal::whereeHas('ingredients', function($query) use ($ingredient)
        {
            $query->where('name', 'like', "%$ingredient%");
        })->with('ingredients')->get();

        return response()->json($meals, 200);
    }
}
