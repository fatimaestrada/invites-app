<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AffiliateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AffiliateController::class)->group(function(){
    Route::get('/affiliates', 'list');
    Route::get('/affiliates/getByDistance', 'distance_filter')->whereNumber('km');
    Route::get('/affiliates/{id}', 'show');
});