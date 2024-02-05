<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/profile",
     *     summary="Андпоинт - получение профиля пользователя.",
     *     description="Возвращает данные профиля пользователя.",
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
    public function profile()
    {
        $user = auth()->user();

        return response()->json([
            "result" => 'OK',
            "user" => $user
        ]);
    }
}
