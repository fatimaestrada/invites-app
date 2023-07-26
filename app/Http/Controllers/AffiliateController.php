<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function list(){
        return Affiliate::getAll()->sort();
    }

    public function show($id)
    {
        return Affiliate::getAll()->where('id', $id)->first();
    }

}
