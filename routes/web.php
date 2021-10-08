<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProgresreportController;
use App\Http\Controllers\OtorisasiController;
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


Route::get('a/{personnel_no}/', 'Auth\LoginController@programaticallyEmployeeLogin')->name('login.a');
Auth::routes();
Route::group(['middleware'    => 'auth'],function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');

});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Otorisasi',[OtorisasiController::class, 'index']);
    Route::get('Otorisasi/ubah',[OtorisasiController::class, 'ubah']);
    Route::get('ViewOtorisasi',[OtorisasiController::class, 'view']);
    Route::post('Otorisasi',[OtorisasiController::class, 'save']);
    Route::post('Otorisasi/update',[OtorisasiController::class, 'update']);

});
Route::group(['middleware'    => 'auth'],function(){
    Route::get('Project',[ProjectController::class, 'index']);
    Route::get('Project/solve',[ProjectController::class, 'solve']);
    Route::get('ViewProject',[ProjectController::class, 'view']);
    Route::post('Project',[ProjectController::class, 'save']);
    Route::post('ProjectTeam',[ProjectController::class, 'save_team']);

});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Progresreport',[ProgresreportController::class, 'index']);
    Route::get('Progresreport/cari_project_team',[ProgresreportController::class, 'cari_project_team']);
    Route::get('Progresreport/hapus_lembur',[ProgresreportController::class, 'hapus_lembur']);
    // Route::get('Progresreport',[ProgresreportController::class, 'index']);
    // Route::get('ViewProgresreport',[ProgresreportController::class, 'view']);
    // Route::post('Progresreport',[ProgresreportController::class, 'save']);

});

Route::group(['middleware'    => 'auth'],function(){
    Route::get('Activitas',[ProgresreportController::class, 'index_personal']);
    Route::get('Activitas/view',[ProgresreportController::class, 'view_project']);
    Route::get('Activitas/personal',[ProgresreportController::class, 'personal_view']);
    Route::get('Timeseet',[ProgresreportController::class, 'timeseet']);
    Route::post('Timeseet',[ProgresreportController::class, 'overtime']);
    Route::get('TimeseetDownload',[ProgresreportController::class, 'timeseetdownload']);
    Route::get('ViewProgresreport',[ProgresreportController::class, 'view']);
    Route::post('Progresreport',[ProgresreportController::class, 'save']);

});
