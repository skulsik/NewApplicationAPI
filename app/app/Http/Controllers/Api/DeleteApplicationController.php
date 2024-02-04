<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicationModel;

class DeleteApplicationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/application/delete_application/{id}",
     *     summary="Андпоинт - удаления заявки.",
     *     description="Удаляет заявку. Возвращает сообщение о успешном удалении и объект заявки.",
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
    public function delete_application($id)
    {
        /** Получает и удаляет заявку */
        $application = ApplicationModel::find($id);
        $application->delete();

        return response()->json([
            'result' => 'OK',
            'application_delete' => 'Заявка успешно удалена!',
            'application' => $application,
        ]);
    }
}
