<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hostes;
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

Route::get('/hostes', [Hostes::class,'index'])->name('hostes.index');
Route::get('/hostes/{grid}/{all}', [Hostes::class,'view'])->name('hostes.view');