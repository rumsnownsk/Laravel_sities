<?php

namespace App\Http\Controllers;

use App\Models\City;

class MainController extends Controller
{
    public function __construct()
    {
        dump(session('city') ? session('city')->toArray()  : 'session is empty');
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
