<?php

use Illuminate\Support\Facades\Route;

/**
 * API маршруты
 */

/** Получение csrf токена */
Route::get('/api/token/get_csrf_token', [App\Http\Controllers\Api\ApiController::class, 'get_csrf_token'])->name('get_csrf_token');

/** Создание заявки */
Route::post('/api/application/create_application', [App\Http\Controllers\Api\ApiController::class, 'create_application'])->name('create_application');

/** Получение всех заявок */
Route::get('/api/application/all_applications', [App\Http\Controllers\Api\ApiController::class, 'get_all_applications'])->name('get_all_applications');

/** Получение одной заявки */
Route::get('/api/application/get_application/{id}', [App\Http\Controllers\Api\ApiController::class, 'get_application'])->name('get_application');

/** Создание заявки */
Route::patch('/api/application/completion_application/{id}', [App\Http\Controllers\Api\ApiController::class, 'completion_application'])->name('completion_application');

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
