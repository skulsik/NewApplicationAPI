<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\Validator\ApiLoginValidator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Андпоинт - авторизация пользователя.",
     *     description="Авторизует пользователя. Возвращает сообщение о ошибках или сообщение о том что пользователь авторизован и токен пользователя.",
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
     *     @OA\Response(response="200", description="Вход совершен."),
     *     @OA\Response(response="401", description="Неверные учетные данные.")
     * )
     */
    public function login(Request $request)
    {
        /** Валидация полей (email, password) */
        $register_validator = new ApiLoginValidator($request);
        $register_validator->run_validator();
        $error = $register_validator->error_validator();

        /** Если есть ошибки валидации, отдает клиенту */
        if ($error)
        {
            return ['result' => 'error', 'errors' => $error];
        }
        else
        {
            // JWTAuth
            $token = JWTAuth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ]);

            if(!empty($token)){

                return response()->json([
                    'result' => 'OK',
                    'message' => 'Вы успешно авторизованы!',
                    'token' => $token
                ]);
            }

            return response()->json([
                'result' => 'error',
                'error' => 'Вы ввели не верные данные.',
            ]);
        }
    }
}
