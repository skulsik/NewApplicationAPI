<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GetApplicationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/application/get_application/{id}",
     *     summary="Андпоинт - получения одной заявки.",
     *     description="Возвращает заявку по id.",
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
    public function get_application($id)
    {
        $application = DB::table('application_models')->find($id);

        return response()->json([
            'result' => 'OK',
            'application' => $application,
        ]);
    }
}
