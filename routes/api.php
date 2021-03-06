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

Route::get('/getServices', 'ServiceController@getServices');
Route::get('/getService/{id}', 'ServiceController@getService');
Route::post('/addService', 'ServiceController@addService');
Route::put('/updateService/{id}', 'ServiceController@updateService');
Route::delete('/deleteService/{id}', 'ServiceController@deleteService');
Route::get('/getServicesFromRecords', 'ServiceController@getServicesFromRecords');

Route::get('/getDrugs', 'DrugController@getDrugs');
Route::get('/getDrug/{id}', 'DrugController@getDrug');
Route::post('/addDrug', 'DrugController@addDrug');
Route::put('/updateDrug/{id}', 'DrugController@updateDrug');
Route::delete('/deleteDrug/{id}', 'DrugController@deleteDrug');
Route::post('/addDrugToReceivingSheet/{sheet_id}/{drug_id}', 'DrugController@addDrugToReceivingSheet');

Route::get('/getSymptoms', 'SymptomController@getSymptoms');
Route::get('/getSymptom/{id}', 'SymptomController@getSymptom');
Route::post('/addSymptom', 'SymptomController@addSymptom');
Route::put('/updateSymptom/{id}', 'SymptomController@updateSymptom');
Route::delete('/deleteSymptom/{id}', 'SymptomController@deleteSymptom');
Route::post('/addSymptomToReceivingSheet/{sheet_id}/{symptom_id}', 'SymptomController@addSymptomToReceivingSheet');

Route::get('/getDiseases', 'DiseaseController@getDiseases');
Route::get('/getDisease/{id}', 'DiseaseController@getDisease');
Route::post('/addDisease', 'DiseaseController@addDisease');
Route::put('/updateDisease/{id}', 'DiseaseController@updateDisease');
Route::delete('/deleteDisease/{id}', 'DiseaseController@deleteDisease');
Route::post('/addDiseaseToReceivingSheet/{sheet_id}/{disease_id}', 'DiseaseController@addDiseaseToReceivingSheet');

Route::get('/getUsers', 'UserController@getUsers');
Route::get('/getUser/{id}', 'UserController@getUser');
Route::get('/getDoctors', 'UserController@getDoctors');
Route::get('/getPatients', 'UserController@getPatients');
Route::get('/getAdmins', 'UserController@getAdmins');
Route::post('/addDoctor', 'UserController@addDoctor');
Route::post('/addPatient', 'UserController@addPatient');
Route::post('/addAdmin', 'UserController@addAdmin');
Route::put('/updateById/{id}', 'UserController@updateById');
Route::put('/updateByToken', 'UserController@updateByToken');
Route::delete('/deleteUser/{id}', 'UserController@deleteUser');
Route::post('/authorization', 'UserController@authorization');
Route::get('/logout', 'UserController@logout');
Route::get('/getDoctorsFromRecordsByService/{service_id}', 'UserController@getDoctorsFromRecordsByService');
Route::get('/getPatientsFromRecordsByDoctor', 'UserController@getPatientsFromRecordsByDoctor');
Route::get('/getDoctorsWithServices', 'UserController@getDoctorsWithServices');
Route::get('/getUserByToken', 'UserController@getUserByToken');

Route::get('/getRecords', 'RecordController@getRecords');
Route::get('/getRecordsByDoctor', 'RecordController@getRecordsByDoctor');
Route::get('/getRecordsByPatient', 'RecordController@getRecordsByPatient');
Route::get('/getRecord/{id}', 'RecordController@getRecord');
Route::post('/addRecord', 'RecordController@addRecord');
Route::put('/updateRecord/{id}', 'RecordController@updateRecord');
Route::put('/addReservation/{id}', 'RecordController@addReservation');
Route::delete('/deleteRecord/{id}', 'RecordController@deleteRecord');
Route::put('/deleteReservation/{id}', 'RecordController@deleteReservation');
Route::get('/getRecordByServiceAndDoctor/{service_id}/{doctor_id}', 'RecordController@getRecordByServiceAndDoctor');

Route::get('/getReceivingSheets', 'ReceivingSheetController@getReceivingSheets');
Route::get('/getReceivingSheetsByDoctor', 'ReceivingSheetController@getReceivingSheetsByDoctor');
Route::get('/getReceivingSheetsByPatient', 'ReceivingSheetController@getReceivingSheetsByPatient');
Route::get('/getReceivingSheet/{id}', 'ReceivingSheetController@getReceivingSheet');
Route::get('/getReceivingSheetToPatient/{id}', 'ReceivingSheetController@getReceivingSheetToPatient');
Route::get('/getReceivingSheetToDoc/{id}', 'ReceivingSheetController@getReceivingSheetToDoc');
Route::post('/addReceivingSheet', 'ReceivingSheetController@addReceivingSheet');
Route::put('/updateReceivingSheet/{id}', 'ReceivingSheetController@updateReceivingSheet');
Route::delete('/deleteReceivingSheet/{id}', 'ReceivingSheetController@deleteReceivingSheet');

Route::get('/ReportTopDoctors/{dateFrom}/{dateTo}', 'ReportController@ReportTopDoctors');
Route::get('/ReportTopServices/{dateFrom}/{dateTo}', 'ReportController@ReportTopServices');
Route::get('/ReportTopPatients/{dateFrom}/{dateTo}', 'ReportController@ReportTopPatients');
Route::get('/ReportTopDiseases/{dateFrom}/{dateTo}', 'ReportController@ReportTopDiseases');
Route::get('/getReportTopDoctors/{dateFrom}/{dateTo}', 'ReportController@getReportTopDoctors');
Route::get('/getReportTopServices/{dateFrom}/{dateTo}', 'ReportController@getReportTopServices');
Route::get('/getReportTopPatients/{dateFrom}/{dateTo}', 'ReportController@getReportTopPatients');
Route::get('/getReportTopDiseases/{dateFrom}/{dateTo}', 'ReportController@getReportTopDiseases');
