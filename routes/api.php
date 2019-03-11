<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/

Route::namespace('Api')->group(function () {
    Route::get('/menu', 'MenuController@index');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Authcontroller@login');
    Route::post('signup', 'Authcontroller@signup');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Authcontroller@logout');
        Route::get('user', 'Authcontroller@user');
    });
});

Route::apiResources(
    [
        'users' => 'Api\UserController',
        'ciclos' => 'Api\CicloController',
        'alumnos' => 'Api\AlumneController',
        'empresas' => 'Api\EmpresaController',
        'ofertas' => 'Api\OfertaController',
        'responsables' => 'Api\ResponsableController'
    ]);