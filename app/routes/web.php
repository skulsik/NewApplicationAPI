<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RefreshTokenController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/**
 * API маршруты
 */

/** Регистрация пользователя */
Route::post("/api/register", [RegisterController::class, "register"]);

/** Авторизация пользователя */
Route::post("/api/login", [LoginController::class, "login"]);

/** Получение csrf токена */
Route::get('/api/token/get_csrf_token', [App\Http\Controllers\Api\GetCsrfTokenController::class, 'get_csrf_token']);

Route::group([
    "middleware" => ["auth:api"]
], function(){
    /** Запрос профиля авторизованного пользователя */
    Route::get("/api/profile", [ProfileController::class, "profile"]);

    /** Обновление токена */
    Route::get("/api/refresh", [RefreshTokenController::class, "refreshToken"]);

    /** Деавторизация пользователя */
    Route::get("/api/logout", [LogoutController::class, "logout"]);

    /** Создание заявки */
    Route::post('/api/application/create_application', [App\Http\Controllers\Api\CreateApplicationController::class, 'create_application']);

    /** Получение всех заявок */
    Route::get('/api/application/all_applications', [App\Http\Controllers\Api\GetAllApplicationsController::class, 'get_all_applications']);

    /** Получение одной заявки */
    Route::get('/api/application/get_application/{id}', [App\Http\Controllers\Api\GetApplicationController::class, 'get_application']);

    /** Запись комментария и заврешение заявки, а так же отправка сообщения на почту */
    Route::patch('/api/application/completion_application/{id}', [App\Http\Controllers\Api\CompletionApplicationController::class, 'completion_application']);

    /** Отправка сообщения клиенту */
    Route::post('/api/application/send_mail_comment_application/{id}', [App\Http\Controllers\Api\SendMailCommentApplicationController::class, 'send_mail_comment_application']);

    /** Удаление заявки */
    Route::get('/api/application/delete_application/{id}', [App\Http\Controllers\Api\DeleteApplicationController::class, 'delete_application']);

    /** Назначение пользователя модератором */
    Route::post('/api/admin/assignment_right', [App\Http\Controllers\Api\Admin\AssignmentRight::class, 'assignment_right']);

    /** Получение всех пользователей */
    Route::get('/api/admin/get_all_users', [App\Http\Controllers\Api\Admin\ListUsersController::class, 'get_all_users']);
});

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
    return redirect('/api/documentation');
});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
