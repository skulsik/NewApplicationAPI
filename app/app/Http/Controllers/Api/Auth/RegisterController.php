<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Api\Validator\ApiRegisterValidator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Андпоинт - регистрация пользователя.",
     *     description="Создает нового пользователя в бд. Возвращает сообщение о ошибке или удачном создании пользователя.",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Имя пользователя.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Электронная почта пользователя.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Пароль.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="Повторите пароль.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Пользователь зарегистрирован."),
     *     @OA\Response(response="401", description="Неверные учетные данные.")
     * )
     */
    public function register(Request $request)
    {
        /** Валидация полей (name, email, password) */
        $register_validator = new ApiRegisterValidator($request);
        $register_validator->run_validator();
        $error = $register_validator->error_validator();

        /** Если есть ошибки валидации, отдает клиенту */
        if ($error)
        {
            return ['result' => 'error', 'errors' => $error];
        }
        else
        {
            /** Создает пользователя в бд.
             * Если есть ошибка, отдает ее в ответ.
             */
            $message = 'Пользователь успешно зарегистрирован!';
            try {
                /** Создает пользователя */
                User::create([
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => Hash::make($request->password)
                ]);
            } catch (QueryException $e) {
                $message = $e->getMessage();
            }

            return response()->json([
                'result' => 'OK',
                'application_create' => $message,
            ]);
        }
    }
}
