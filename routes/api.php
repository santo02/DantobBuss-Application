<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\RoutesController;
use App\Models\bus;
use Illuminate\Support\Facades\Route;

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

Route::post('registrasi', [RegisterUserController::class, 'RegisterUser']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Welcome Admin';
    });
    Route::post('/registrasi/supir', [RegisterUserController::class, 'RegistrasiSupir']);
    Route::post('/buss/add', [BusController::class, 'store']);
    Route::get('/buss/show/all', [BusController::class, 'show']);
    Route::put('/buss/update/{id}', [BusController::class, 'update']);
    Route::delete('/buss/delete/{id}', [BusController::class, 'delete']);

    Route::post('/routes/add', [RoutesController::class, 'store']);
    Route::put('/routes/update/{id}', [RoutesController::class, 'update']);
    Route::get('/routes/show/all', [RoutesController::class, 'index']);
    Route::delete('/routes/destroy/{id}', [RoutesController::class, 'destroy']);
});

Route::middleware(['auth:api', 'role:penumpang'])->group(function () {
    Route::get('/penumpang', function () {
        return 'Welcome penumpang';
    });
});

Route::middleware(['auth:api', 'role:supir'])->group(function () {
    Route::get('/supir', function () {
        return 'Welcome supir';
    });
});



