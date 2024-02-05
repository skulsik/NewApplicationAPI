<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ListUsersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/get_all_users",
     *     summary="Андпоинт - получения всех пользователей.",
     *     description="Возврат всех пользователей.",
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
    public function get_all_users()
    {
        if (auth()->user()->hasRole('root'))
        {
            $users = User::with('roles')->get();

            return response()->json([
                'result' => 'OK',
                'list_users' => $users,
            ]);
        }
        else
            return response()->json([
                'result' => 'OK',
                'message' => 'У вас недостаточно прав.',
            ]);
    }
}
