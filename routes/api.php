<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ConfirmPembayaran;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Bookings;
use App\Models\bus;
use App\Models\Role;
use App\Utils\SignatureDoku;
use Illuminate\Http\Client\Request;
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

// Route::post('/pembayaran', [PembayaranController::class, 'generateToken']);


Route::post('registrasi', [RegisterUserController::class, 'RegisterUser']);
Route::post('login', [LoginController::class, 'login']);
// Route::get('signature', function () {
//     // return $request;
//     $signature = SignatureDoku::generateToken();

//     return $signature;
// });

// Route::post('logout', [LoginController::class, 'logout']th);
Route::get('/schedule/show/all', [ScheduleController::class, 'index']);

Route::middleware(['auth:api', 'role:admin_loket,admin_kantor,driver,passenger'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('/user/profile', [UserController::class, 'user']);
});


Route::middleware(['auth:api', 'role:admin_loket, admin_kantor, driver,passenger'])->group(function () {

    Route::get('/schedule/show/{id}', [ScheduleController::class, 'SelectOne']);
    Route::get('/schedule/type/executive', [ScheduleController::class, 'ShowExecutive']);
    Route::get('/schedule/type/economi', [ScheduleController::class, 'ShowEconomi']);
    Route::post('bookings', [BookingController::class, 'store']);
    Route::post('bookings/nontunai', [PembayaranController::class, 'generateToken']);
    Route::get('/bookings/show/schedules/{id}', [BookingController::class, 'getOneSchedules']);
    Route::get('/bookings/show/{id}', [BookingController::class, 'getOne']);
    Route::get('/pesanan/ticket/{id}', [TicketController::class, 'index']);
    Route::get('/bookings/my', [BookingController::class, 'getByUserId']);
});


Route::middleware(['auth:api', 'role:admin_loket'])->group(function () {

    Route::get('/bookings/index/all', [BookingController::class, 'index']);
    Route::put('/bookings/update/{id}', [BookingController::class, 'update']);
});

Route::middleware(['auth:api', 'role:passenger'])->group(function () {
    // Route::get('/bookings/my', [BookingController::class, 'getByUserId']);
});


Route::middleware(['auth:api', 'role:admin_kantor'])->group(function () {
    Route::post('/registrasi/supir', [RegisterUserController::class, 'RegistrasiSupir']);
    Route::get('/supir/all', [SupirController::class, 'index']);
    Route::get('/supir/name/all', [SupirController::class, 'getOne']);

    Route::post('/buss/add', [BusController::class, 'store']);
    Route::get('/buss/show/all', [BusController::class, 'show']);
    Route::put('/buss/update/{id}', [BusController::class, 'update']);
    Route::delete('/buss/delete/{id}', [BusController::class, 'delete']);

    Route::post('/routes/add', [RoutesController::class, 'store']);
    Route::put('/routes/update/{id}', [RoutesController::class, 'update']);
    Route::get('/routes/show/all', [RoutesController::class, 'index']);
    Route::delete('/routes/destroy/{id}', [RoutesController::class, 'destroy']);

    Route::post('/schedule/add', [ScheduleController::class, 'store']);
});

Route::middleware(['auth:api', 'role:driver'])->group(function () {
    Route::get('/schedules/driver', [ScheduleController::class, 'getForSupir']);
    Route::get('/confirmasi-pembayaran', [ConfirmPembayaran::class, 'index']);
});
