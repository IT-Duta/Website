<?php

use App\Http\Controllers\generalAffair;
use App\Http\Controllers\pn_05_logistik_controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/list','controller@index')->name('list_index');

Route::get('/list/create','controller@create')->name('list_create');
Route::post('/list/store','controller@store')->name('list_store');

Route::get('/list/edit/{id}','controller@edit')->name('list_edit');
Route::post('/list/update','controller@update')->name('list_update');

require __DIR__.'/auth.php';
