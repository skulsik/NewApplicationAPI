<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/logout",
     *     summary="Андпоинт - деавторизация.",
     *     description="Возвращает сообщение о успешной деавторизации.",
     *     @OA\Response(
     *         response="200",
     *         description="Успешно."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Что-то пошло не так.",
     *     )
     * )
     */
    public function logout(){

        auth()->logout();

        return response()->json([
            "result" => 'OK',
            "message" => "Вы успешно деавторизированы."
        ]);
    }
}
