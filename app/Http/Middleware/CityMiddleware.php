<?php

namespace App\Http\Middleware;

use App\Models\City;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $prefixCity = ltrim(request()->route()->getPrefix(),'/');
        $uri = $request->path();

//        dd(!$city);
        if (!$prefixCity && session('city')) {
//            dd('/'.session('city.slug').'/'.$uri);
            return redirect('/'.session('city.slug').'/'.$uri, 301);
        }

        if (!$prefixCity && Route::currentRouteName() !=='index') {
            abort(404);
        }

        if ($prefixCity) {
            $citi_data = City::query()->where('slug', $prefixCity)->firstOrFail();
            session(['city' => $citi_data]);
        }

        return $next($request);
    }
}
