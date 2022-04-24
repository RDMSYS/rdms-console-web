<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hostes;
use App\Http\Controllers\Users;
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
Route::get('/device/{id}', [Hostes::class,'show'])->name('hostes.show');
Route::get('/device/{id}/baseboard', [Hostes::class,'getBaseboard'])->name('host.baseboard.show');
Route::get('/device/{id}/cpu', [Hostes::class,'getCpu'])->name('host.cpu.show');
Route::get('/device/{id}/primary/memory', [Hostes::class,'getRam'])->name('host.ram.primary.memory');
Route::get('/device/{id}/os', [Hostes::class,'getOs'])->name('host.os.show');
Route::get('/device/{id}/secondary/memory', [Hostes::class,'getHdd'])->name('host.hdd.show');
Route::get('/device/{id}/gpu', [Hostes::class,'getGpu'])->name('host.gpu.show');
Route::get('/device/{id}/ldisk', [Hostes::class,'getLdisk'])->name('host.ldisk.show');
Route::get('/device/{id}/io', [Hostes::class,'getIo'])->name('host.io.show');
Route::get('/device/{id}/softwares/{softid}', [Hostes::class,'getSoftwaresDetailed'])->name('host.softwares.verbose');
Route::get('/device/{id}/softwares', [Hostes::class,'getSoftwares'])->name('host.softwares.show');
Route::get('/device/{id}/useraccounts', [Hostes::class,'getUserAccounts'])->name('host.useraccounts.show');
Route::get('/device/{id}/network/adapters', [Hostes::class,'getNetAdapter'])->name('host.adapters.show');
Route::get('/device/{id}/network/ip/{intid}', [Hostes::class,'getNetAdapterIp'])->name('host.ip.show');
Route::get('/device/update/device/db/{id}', [Hostes::class,'updateDevDb'])->name('hostes.device.update');
// Route::get('/device/{id}', [Hostes::class,'show'])->name('hostes.show');
// Route::get('/device/{id}', [Hostes::class,'show'])->name('hostes.show');
Route::get('/devices/create', [Hostes::class,'create'])->name('hostes.create');
Route::post('/device/add', [Hostes::class,'store'])->name('hostes.store');
Route::get('/devices/{viewtype}/{hoststatus}', [Hostes::class,'view'])->name('hostes.view');

Route::get('/user/create', [Users::class,'create'])->name('user.create');
