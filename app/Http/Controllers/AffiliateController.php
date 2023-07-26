<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $cities = getCities();

        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'km' => 'required|integer'
        ]);
        $from = strtoupper($request->from);
        $distanceKm = $request->km;

        $validator->after(function ($validator) use ($from, $cities) {
            $validCities = array_keys(getCities());
            if (!in_array($from, $validCities)) {
                $validator->errors()->add('from', 'Please enter a valid City');
            }
        });

        if ($validator->fails()) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'messages' => $validator->errors()->all()
                ], 404)
            );
        };


        $affiliatesWithinDistance = array();

        foreach (Affiliate::getAll()->sort() as $affiliate) {
            $dist = calculate_distance($cities[$from], $affiliate->location);
            if ($dist <= $distanceKm) array_push($affiliatesWithinDistance, $affiliate);

            $affiliate->distance = number_format((float)$dist, 2);
        }

        return $affiliatesWithinDistance;
    }
}
