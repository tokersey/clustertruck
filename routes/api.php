<?php

use Illuminate\Http\Request;

use App\Http\Controllers\KitchenController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/kitchens', 'KitchenController@getKitchens');

Route::post('/kitchens/getDriveTimeByDirections', function(Request $request) {
    $kitchenController = new KitchenController();
    return $kitchenController->getDriveTimeByDirections($request);
});

Route::post('/kitchens/getDriveTimeByDistanceMatrix', function(Request $request) {
    $kitchenController = new KitchenController();
    return $kitchenController->getDriveTimeByDistanceMatrix($request);
});
