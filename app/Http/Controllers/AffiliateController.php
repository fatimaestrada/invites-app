<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AffiliateController extends Controller
{
    public function list()
    {
        return Affiliate::getAll()->sort();
    }

    public function show($id)
    {
        return Affiliate::getAll()->where('id', $id)->first();
    }

    /**
     * Returns the list of affiliates by given city and distance in km.
     *
     * @param string from: City Name
     * @param string km
     */
    public function distance_filter(Request $request)
    {
        $cities = array_keys(getCities());

        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'km' => 'required|integer'
        ]);

        $from = $request->from;
        $distanceKm = $request->km;
        error_log(json_encode($cities));

        $validator->after(function ($validator) use ($from, $cities) {
            if (!in_array(strtoupper($from), $cities)) {
                $validator->errors()->add('from', 'Please enter a valid City');
            }
        });


        if ($validator->fails()) {
            return $validator->errors();
        };

        return "From $from withinn $distanceKm km";
    }
}
