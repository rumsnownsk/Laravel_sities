<?php

use App\Helpers\CitySlug;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;


Route::get('/reset', function () {
    session()->forget('city');
    return redirect()->route('index');
})->name('reset');

Route::prefix(CitySlug::getSlug())->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/about', [MainController::class, 'about'])->name('about');
    Route::get('/news', [MainController::class, 'news'])->name('news');
})->middleware('city');

Route::prefix('api')->group(function () {
    Route::get('/', function () {
        $response = \Illuminate\Support\Facades\Http::post('https://countriesnow.space/api/v0.1/countries/population/cities', [
            "city" => "lagos"
        ]);
        return response()->json([
            'data' => $response->json()
        ]);
    });
    Route::get('/getCities', [CityController::class, 'getCities']);
});

