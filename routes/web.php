<?php

use App\Helpers\CitySlug;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::post('/postre', function (){
    return 'data';
});


Route::get('/reset', function () {
    session()->forget('city');
    return redirect()->route('index');
})->name('reset');

Route::get('/app', function () {
    return view('layouts.hiPage');
});
Route::get('/posts/{id?}', function ($id=null) {
    return view('layouts.posts', [
        'posts' => $id,
//        'comment_id' => $comment_id
    ]);
});

Route::get('/posts/{slug}', function ($slug) {
    return view('layouts.slug', [
        'slug' => $slug,
    ]);
});
Route::get('/search/{srch}', function ($srch) {
    return view('layouts.slug', [
        'slug' => $srch,
    ]);
});

Route::prefix(CitySlug::getSlug())->middleware('city')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/about', [MainController::class, 'about'])->name('about');
    Route::get('/news', [MainController::class, 'news'])->name('news');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
});

Route::prefix('api')->group(function () {
    Route::get('/', function () {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/population/cities', [
            "city" => "lagos"
        ]);
        return response()->json([
            'data' => $response->json()
        ]);
    });
    Route::get('/getCountriesCapitals', [CityController::class, 'getCountriesCapitals']);
    Route::get('/getcities', [CityController::class, 'getCities']);
});

Route::prefix('admin')->group(function (){
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/workWithFacadeDB', [AdminController::class, 'workWithFacadeDB'])->name('admin.facadeDB');
    Route::get('/relationOneToOne', [AdminController::class, 'relationOneToOne'])->name('admin.relationOneToOne');
    Route::get('/relationOneToMany', [AdminController::class, 'relationOneToMany'])->name('admin.relationOneToMany');
    Route::get('/relationManyToMany', [AdminController::class, 'relationManyToMany'])->name('admin.relationManyToMany');
    Route::get('/relationSave', [AdminController::class, 'relationSave'])->name('admin.relationSave');
    Route::get('/about', [AdminController::class, 'about'])->name('admin.about');
    Route::get('/contact', [AdminController::class, 'contact'])->name('admin.contact');
    Route::get('/insertusers', [AdminController::class, 'insertUsers'])->name('admin.insertUsers');
});
