<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class GetCsrfTokenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/token/get_csrf_token",
     *     summary="Андпоинт - получения csrf токена.",
     *     description="Возвращает csrf токен, необходим для создания заявки, заявка создается неавторизованным пользователем",
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
    public function get_csrf_token()
    {
        return response()->json([
            'result' => 'OK',
            'csrf_token' => csrf_token(),
        ]);
    }
}
