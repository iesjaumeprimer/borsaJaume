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
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResources(
        [   'users' => 'Api\UserController',
            'alumnos' => 'Api\AlumnoController',
            'empresas' => 'Api\EmpresaController',
            'ofertas' => 'Api\OfertaController',
            'ciclos' => 'Api\CicloController',
            'responsables' => 'Api\ResponsableController'
        ]);
    Route::put('ofertas/{id}/alumno', 'Api\OfertaController@AlumnoInterested');
});
