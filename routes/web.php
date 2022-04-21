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

Route::get('/devices', [Hostes::class,'index'])->name('hostes.index');
Route::get('/device/{id}/baseboard', [Hostes::class,'getBaseboard'])->name('host.baseboard.show');
Route::get('/device/{id}/cpu', [Hostes::class,'getCpu'])->name('host.cpu.show');
Route::get('/device/{id}/primary/memory', [Hostes::class,'getRam'])->name('host.ram.primary.memory');
Route::get('/device/{id}/os', [Hostes::class,'getOs'])->name('host.os.show');
Route::get('/device/{id}/secondary/memory', [Hostes::class,'getHdd'])->name('host.hdd.show');
Route::get('/device/{id}/gpu', [Hostes::class,'getGpu'])->name('host.gpu.show');
Route::get('/device/{id}/ldisk', [Hostes::class,'getLdisk'])->name('host.ldisk.show');
Route::get('/device/{id}', [Hostes::class,'show'])->name('hostes.show');
// Route::get('/device/{id}', [Hostes::class,'show'])->name('hostes.show');
// Route::get('/device/{id}', [Hostes::class,'show'])->name('hostes.show');
// Route::get('/device/{id}', [Hostes::class,'show'])->name('hostes.show');


Route::get('/devices/create', [Hostes::class,'create'])->name('hostes.create');
Route::post('/device/add', [Hostes::class,'store'])->name('hostes.store');
Route::get('/devices/{viewtype}/{hoststatus}', [Hostes::class,'view'])->name('hostes.view');