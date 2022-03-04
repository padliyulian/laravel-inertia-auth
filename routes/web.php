<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest'], function() {
    Route::get('/', function () {
        return redirect('/login');
    });
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'getLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'postLogin']);
});

Route::group(['middleware' => 'auth'], function() {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'postLogout']);

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

    Route::group(
        [
            'middleware' => 'role:admin',
            // 'namespace' => 'Diskusi',
            'prefix' => 'roles',
            'name' => 'roles.'
        ],
        function() {
            Route::get('/', [\App\Http\Controllers\RoleController::class, 'index']);
            Route::get('/create', [\App\Http\Controllers\RoleController::class, 'create']);
            Route::post('/', [\App\Http\Controllers\RoleController::class, 'store']);
            Route::get('/edit/{id}', [\App\Http\Controllers\RoleController::class, 'edit']);
            Route::patch('/{id}', [\App\Http\Controllers\RoleController::class, 'update']);
            Route::delete('/{id}', [\App\Http\Controllers\RoleController::class, 'destroy']);

            Route::get('/permissions/{id}', [\App\Http\Controllers\RoleController::class, 'getPermission']);
            Route::patch('/permissions/{id}', [\App\Http\Controllers\RoleController::class, 'updatePermission']);
        }
    );

    Route::group(
        [
            'middleware' => 'role:admin',
            // 'namespace' => 'Diskusi',
            'prefix' => 'users',
            'name' => 'users.'
        ],
        function() {
            Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);
            Route::get('/create', [\App\Http\Controllers\UserController::class, 'create']);
            Route::post('/', [\App\Http\Controllers\UserController::class, 'store']);
            Route::get('/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit']);
            Route::patch('/{id}', [\App\Http\Controllers\UserController::class, 'update']);
            Route::delete('/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
        }
    );
});
