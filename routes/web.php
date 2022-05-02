<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hostes;
use App\Http\Controllers\Users;
use App\Http\Controllers\AuthController;
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

Route::group(['middleware' => ['AuthCheck']], function () {
    Route::get('/devices', [Hostes::class, 'index'])->name('hostes.index');
    Route::get('/device/{id}', [Hostes::class, 'show'])->name('hostes.show');
    Route::get('/device/{id}/baseboard', [Hostes::class, 'getBaseboard'])->name('host.baseboard.show');
    Route::get('/device/{id}/cpu', [Hostes::class, 'getCpu'])->name('host.cpu.show');
    Route::get('/device/{id}/primary/memory', [Hostes::class, 'getRam'])->name('host.ram.primary.memory');
    Route::get('/device/{id}/os', [Hostes::class, 'getOs'])->name('host.os.show');
    Route::get('/device/{id}/secondary/memory', [Hostes::class, 'getHdd'])->name('host.hdd.show');
    Route::get('/device/{id}/gpu', [Hostes::class, 'getGpu'])->name('host.gpu.show');
    Route::get('/device/{id}/ldisk', [Hostes::class, 'getLdisk'])->name('host.ldisk.show');
    Route::get('/device/{id}/io', [Hostes::class, 'getIo'])->name('host.io.show');
    Route::get('/device/{id}/softwares/{softid}', [Hostes::class, 'getSoftwaresDetailed'])->name('host.softwares.verbose');
    Route::get('/device/{id}/softwares', [Hostes::class, 'getSoftwares'])->name('host.softwares.show');
    Route::get('/device/{id}/useraccounts', [Hostes::class, 'getUserAccounts'])->name('host.useraccounts.show');
    Route::get('/device/{id}/network/adapters', [Hostes::class, 'getNetAdapter'])->name('host.adapters.show');
    Route::get('/device/{id}/network/ip/{intid}', [Hostes::class, 'getNetAdapterIp'])->name('host.ip.show');
    Route::get('/device/update/device/db/{id}', [Hostes::class, 'updateDevDb'])->name('hostes.device.update');
    Route::get('/device/{id}/services', [Hostes::class, 'getServices'])->name('host.services.show');
    Route::get('/device/{id}/devicemanager', [Hostes::class, 'getDevMgmt'])->name('host.devicemanager.show');
    Route::get('/device/{id}/process', [Hostes::class, 'getProcess'])->name('host.process.show');
    Route::delete('/device/{id}', [Hostes::class, 'destroy'])->name('host.distroy');
    Route::get('/device/{id}/edit', [Hostes::class, 'edit'])->name('host.edit');
    Route::post('/device/{id}/update', [Hostes::class, 'update'])->name('host.update');

    Route::get('/devices/create', [Hostes::class, 'create'])->name('hostes.create')->middleware('Admin');
    Route::post('/device/add', [Hostes::class, 'store'])->name('hostes.store')->middleware('Admin');
    Route::get('/devices/{viewtype}/{hoststatus}', [Hostes::class, 'view'])->name('hostes.view');
    // Route::get('/devices/autodiscovery', [Hostes::class, 'autoDiscovery'])->name('hostes.autodiscoevry');
    

    Route::get('/user/create', [Users::class, 'create'])->name('user.create')->middleware('Admin');;
    Route::post('/user/create', [Users::class, 'store'])->name('user.store')->middleware('Admin');;
    Route::get('/users', [Users::class, 'index'])->name('users.index')->middleware('Admin');;
    Route::delete('/user/{id}', [Users::class, 'destroy'])->name('users.destroy')->middleware('Admin');;
    Route::get('/user/profile', [Users::class, 'show'])->name('user.show');
    Route::get('/user/password/change', [Users::class, 'edit'])->name('user.edit');
    Route::put('/user/password/change', [Users::class, 'change'])->name('user.change');



    Route::get('/settings', function () {
        return view("settings");
    })->name('settings.index');


    Route::get('/dashboard', function () {
        return view("dashboard");
    })->name('dashboard.index');


    Route::get('/', function () {
        return redirect('/dashboard');
    });


    Route::get('/login', [AuthController::class, 'loginView'])->name('auth.login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('logout', function () {
        if (session()->has('id')) {
            session()->pull('id');
        }
        if (session()->has('realname')) {
            session()->pull('realname');
        }
        if (session()->has('level')) {
            session()->pull('level');
        }
        if (session()->has('email')) {
            session()->pull('email');
        }
        return redirect('login')->with('success', "Successfully logout");
    })->name('logout');
});
