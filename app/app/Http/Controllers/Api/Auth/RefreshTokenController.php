<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/refresh",
     *     summary="Андпоинт - обновление токена.",
     *     description="Возвращает свеже - сгенерированный токен.",
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
    public function refreshToken(){

        $newToken = auth()->refresh();

        return response()->json([
            "result" => 'OK',
            "message" => "Новый токен.",
            "token" => $newToken
        ]);
    }
}
