<?php

use App\Http\Controllers\ConversionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/codes', [ConversionController::class, 'getCurrencyConversionCodes']);
Route::get('/conversion', 'ConversionController@convert');
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/conversion', 'ConversionController@store');
    Route::post('/conversion/{id}', 'ConversionController@update');
    Route::get('/conversions', 'ConversionController@index');
});



