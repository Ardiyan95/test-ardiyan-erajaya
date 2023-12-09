<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Check;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

// Auth::routes();

Route::post('proses.login', 'UserController@ProsesLogin')->name('proses.login');

Route::group(['middleware' => ['auth']], function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('quiz', 'MainController@index')->name('quiz');

    Route::get('getQuestion', 'MainController@getDataQuestion')->name('getQuestion');

    Route::get('dashboard', 'MainController@dashboard')->name('dashboard');

    Route::post('insertDataSoal', 'MainController@insDataSoal')->name('insertDataSoal');

    Route::post('editDataSoal', 'MainController@edtDataSoal')->name('editDataSoal');

    Route::post('DeteleDataEditQns/{idData}', 'MainController@deleteDataSoal');

    Route::get('getDataEditQns/{idData}', 'MainController@getEditQns');

});

