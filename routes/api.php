<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RelativeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::resource('user', UserController::class);
Route::post('/user-update/{id}', [UserController::class, 'updateUser']);

Route::resource('employee', EmployeeController::class);
Route::post('/employee-update/{id}', [EmployeeController::class, 'updateEmployee']);

Route::resource('relative', RelativeController::class);
Route::post('/relative-update/{id}', [RelativeController::class, 'updateRelative']);
Route::post('me', [AuthController::class, 'me']);

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('profile', [AuthController::class, 'profile']);
    
});