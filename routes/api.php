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
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getServices', 'ServiceController@getServices');
Route::get('/getService/{id}', 'ServiceController@getService');
Route::post('/addService', 'ServiceController@addService');
Route::put('/updateService/{id}', 'ServiceController@updateService');
Route::delete('/deleteService/{id}', 'ServiceController@deleteService');

Route::get('/getDrugs', 'DrugController@getDrugs');
Route::get('/getDrug/{id}', 'DrugController@getDrug');
Route::post('/addDrug', 'DrugController@addDrug');
Route::put('/updateDrug/{id}', 'DrugController@updateDrug');
Route::delete('/deleteDrug/{id}', 'DrugController@deleteDrug');

Route::get('/getSymptoms', 'SymptomController@getSymptoms');
Route::get('/getSymptom/{id}', 'SymptomController@getSymptom');
Route::post('/addSymptom', 'SymptomController@addSymptom');
Route::put('/updateSymptom/{id}', 'SymptomController@updateSymptom');
Route::delete('/deleteSymptom/{id}', 'SymptomController@deleteSymptom');

Route::get('/getDiseases', 'DiseaseController@getDiseases');
Route::get('/getDisease/{id}', 'DiseaseController@getDisease');
Route::post('/addDisease', 'DiseaseController@addDisease');
Route::put('/updateDisease/{id}', 'DiseaseController@updateDisease');
Route::delete('/deleteDisease/{id}', 'DiseaseController@deleteDisease');

Route::get('/getUsers', 'UserController@getUsers');
Route::get('/getUser/{id}', 'UserController@getUser');
Route::get('/getDoctors', 'UserController@getDoctors');
Route::get('/getPatients', 'UserController@getPatients');
Route::get('/getAdmins', 'UserController@getAdmins');
Route::post('/addDoctor', 'UserController@addDoctor');
Route::post('/addPatient', 'UserController@addPatient');
Route::post('/addAdmin', 'UserController@addAdmin');
Route::put('/updateById/{id}', 'UserController@updateById');
Route::put('/updateByToken/{token}', 'UserController@updateByToken');
Route::delete('/deleteUser/{id}', 'UserController@deleteUser');
Route::post('/authorization', 'UserController@authorization');
