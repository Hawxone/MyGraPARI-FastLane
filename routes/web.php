<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/tes', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('view-data', 'AuthorizationController@viewData');
Route::get('create-data', 'AuthorizationController@createData');
Route::get('edit-data', 'AuthorizationController@editData');
Route::get('update-data', 'AuthorizationController@updateData');
Route::get('delete-data', 'AuthorizationController@deleteData');



Route::group(['middleware' => 'auth'], function (){

    //Navigator
    Route::get('/navigator', 'AntrianController@index_navigator')->name('navigator.index');
    Route::post('/navigator/stor', 'AntrianController@store')->name('navigator.create');



    //Ambassador
    Route::get('/ambassador', 'AntrianController@index_ambassador')->name('ambassador.index');
    Route::post('/ambassador/panggil', 'AntrianController@create')->name('ambassador.panggil');
    Route::post('/ambassador/selesai', 'AntrianController@show')->name('ambassador.selesai');
    Route::post('/ambassador/skip', 'AntrianController@skip')->name('ambassador.skip');
    Route::post('/ambassador/waiting', 'ReportingController@store')->name('ambassador.waiting');
    Route::post('/ambassador/current','AntrianController@current_user')->name('ambassador.current');

    //Monitoring
    Route::get('/monitoring', 'MonitorController@index')->name('monitoring.index');
    Route::get('/monitoring/revenue', 'MonitorController@revenue')->name('monitoring.revenue');
    Route::get('/monitoring/revenue2', 'MonitorController@revenue2')->name('monitoring.revenue2');
    Route::get('/monitoring/issued', 'LogController@issuedindex')->name('monitoring.issued');
    Route::get('/monitoring/waiting', 'LogController@waitingindex')->name('monitoring.waiting');
    Route::get('/monitoring/served', 'LogController@servedindex')->name('monitoring.served');
    Route::get('/monitoring/unserved', 'LogController@unservedindex')->name('monitoring.unserved');
    Route::get('/monitoring/serving', 'LogController@servingindex')->name('monitoring.serving');

    //Reporting
    Route::get('/reporting', 'ReportingController@index')->name('reporting.index');
    Route::post('/reporting/get', 'ReportingController@show')->name('reporting.show');
    Route::post('/reporting/export', 'ReportingController@export')->name('reporting.export');
    Route::get('/reporting/unserved','ReportingController@unservedindex')->name('reporting.unserved');
    Route::get('/reporting/revenue','ReportingController@revenueindex')->name('reporting.revenue');
    Route::post('/reporting/get-unserved', 'ReportingController@showunserved')->name('reporting.show_unserved');
    Route::post('/reporting/get-revenue', 'ReportingController@showrevenue')->name('reporting.show_revenue');
    Route::post('/reporting/export-unserved', 'ReportingController@exportunserved')->name('reporting.export_unserved');

    //Revenue
    Route::get('/revenue/{username}/input', 'RevenueController@index')->name('revenue.index');
    Route::get('/revenue/{username}/delete/{id}', 'RevenueController@destroy')->name('revenue.delete');
    Route::post('/revenue/store', 'RevenueController@store')->name('revenue.store');
    Route::get('/revenue/{username}', 'RevenueController@show')->name('revenue.show');
    Route::get('/revenue/{username}/update', 'RevenueController@create')->name('revenue.showdate');
    Route::post('/revenue/edit','RevenueController@edit')->name('revenue.edit');
    Route::post('/revenue/update','RevenueController@update')->name('revenue.update');

    //Libur
    Route::get('/libur','LiburController@index')->name('libur.index');
    Route::post('/libur/store','LiburController@store')->name('libur.store');
    Route::get('/libur/delete/{id}','LiburController@destroy')->name('libur.destroy');

});

