<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

Route::group(['middleware' => 'redirect.if.not.authorized:admin'], function () {
    // Routes accessible by employees and admins, otherwise redirects to /unauthorized
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

Route::get('/unauthorized', function () {
    return view('auth.login');
});

Route::get('/dashboard/users', function () {
    return view('tables.user');
});

Route::get('/dashboard/employees', function () {
    return view('tables.employee');
});

Route::get('/dashboard/relatives', function () {
    return view('tables.relative');
});

// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/logout', [AuthController::class, 'logout']);

// Route::post('me', [AuthController::class, 'profile']);
Route::view('/login', 'auth.login');
Route::view('/register', 'auth.register');