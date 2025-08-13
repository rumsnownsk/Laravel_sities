<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct()
    {
//        dump(session('city'));
        dump(session('city') ? session('city')->toArray()  : 'session is empty');

        $city = request()->route('city');

        if (!$city && session('city')) {
            return redirect()->route('index', session('city.slug'), 301);
        }

        if ($city) {
            $city_data = City::query()->where('slug', '=', $city)->firstOrFail();
            session(['city' => $city_data]);
        }
//        dump(session('city') ? session('city')->toArray()  : 'session is empty');

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

    public function about ($city)
    {
        $cities = City::all();
        return view('main.about', compact('cities'));
    }

    public function news ($city)
    {
        $cities = City::all();
        return view('main.news', compact('cities'));
    }
}
