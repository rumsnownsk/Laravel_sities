<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function getCountriesCapitals()
    {
        dump(__METHOD__);
        $result = Http::get('https://countriesnow.space/api/v0.1/countries/capital');
        dump($result->json());

    }

    /**
     * @throws ConnectionException
     */
    public function getCities(): string
    {
//        dd(__METHOD__);

        $citiesList = Http::retry(3, 100)->post('https://countriesnow.space/api/v0.1/countries/cities',[
            'country'=>'france',
        ])->json();
        dump($citiesList);
        if (empty($citiesList['data'])){
            return $citiesList['msg'];
        }
        City::query()->truncate();


        $anyCities = array_rand($citiesList['data'], 10);
        $newCitiesList = [];
        foreach ($anyCities as $k => $cityId){
            $newCitiesList['data'][$k] = $citiesList['data'][$cityId];
        }
        dump($newCitiesList);

//        $cities_chunk = array_chunk($citiesList['data'], 500);
        $cities_chunk = array_chunk($newCitiesList['data'], 500);

//        dump($cities_chunk);
        $ignored = 0;

        foreach ($cities_chunk as $cities){
            $values = [];
            foreach ($cities as $city){
                $values[] = [
                    'title'=>$city,
                    'slug'=>Str::slug($city),
                    'created_at'=>now(),
                    'updated_at'=>now()
                ];
            }
            $inserts = DB::table('cities')->insertOrIgnore($values);

            $ignored += (count($values) - $inserts);
        }
        $count = count($citiesList['data']);

        return "Count all cities: {$count} | Inserted: {$inserts} | Ignored: {$ignored}". " | <a href='/'>home</a>" ;

    }
}
