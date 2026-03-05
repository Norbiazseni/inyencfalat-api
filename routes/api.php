<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\IngredientController;
use App\Models\Meal;
use App\Models\Ingredient;


// GET /api/meals – Listázza az összes ételt összetevőikkel együtt.

Route::get('/meals', [MealController::class, 'index']);
// ● POST /api/meals – Új étel létrehozása és hozzárendelése összetevőkhöz.
Route::post('/meals', [MealController::class, 'store']);
// ● PUT /api/meals/{id} – Étel módosítása
Route::put('/meals/{id}', [MealController::class, 'update']);
// ● GET /api/ingredients – Listázza az összes összetevőt.
Route::get('/ingredients', [IngredientController::class, 'index']);
// ● GET /api/meals/search/{ingredient} – Kilistázza azokat az ételeket, amelyek
// tartalmazzák a megadott összetevőt.
Route::get('/meals/search/{ingredient}', [MealController::class, 'search']);