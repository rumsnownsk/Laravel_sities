<?php

namespace App\Http\Controllers;

use App\Models\City;

class MainController extends Controller
{
    public function __construct()
    {
        dump(session('city') ? session('city')->toArray()  : 'session is empty');
//        if (!cookie('city')) {
//            setcookie('city', session('city')->toArray(), time() + (86400 * 30), "/");
//        }
//        dump($_COOKIE['laravel_session']);

    }
    public function jsonView(): string
    {
        $data = City::all();
        return response()->json([
            'data' => $data
        ]);
    }

    public function index ($city = null)
    {
//        if (!$city && session('city')) {
//            return redirect()->route('index', session('city.slug'), 301);
//        }
//
//        if ($city) {
//            $city_data = City::query()->where('slug', '=', $city)->firstOrFail();
//            session(['city' => $city_data]);
//        }

        $cities = City::all();
        return view('main.index', compact('cities'));
    }

    public function about ()
    {
        $cities = City::all();
        return view('main.about', compact('cities'));
    }

    public function news ()
    {
        $cities = City::all();
        return view('main.news', compact('cities'));
    }
}
