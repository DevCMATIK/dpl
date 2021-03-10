<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum','verified'])->group(function() {
    //TESTS
    Route::namespace('App\Http\Test\Controllers')->group(function() {
        Route::get('test-report-insertion','TestReportTableController@testInsertion');
        Route::get('test-inventia-connection','TestInventiaConnectionController@testConnection');
        Route::get('test-device-data','TestDevicesDataController@testData');
        Route::get('test-sensor-data','TestSensorsDataController@testData');
        Route::get('test-device-with-last-report','TestDeviceWithLastReportController@testData');
    });

    Route::namespace('App\Http\DPL\Device')->group(function() {
        Route::get('define-devices','DefineDevicesController@defineDevices');
    });
    Route::namespace('App\Http\DPL\Sensor')->group(function() {
        Route::get('define-sensors','DefineSensorsController@defineSensors');
    });
});

Route::get('/broadcast', function () {
    broadcast(new \App\Events\Test());
});
