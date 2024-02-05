<?php

namespace App\Http\Controllers\Api;

class GetAllApplicationsController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/application/all_applications",
     *     summary="Андпоинт - получения всех заявок.",
     *     description="Без использования фильтров, возвращает все заявки (дефолтно сортировка по дате в порядке возрастания). Фильтр: status=false - все незавершенные заявки, status=true - все завершенные заявки, date - обратная сортировка по дате.",
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
    public function get_all_applications()
    {
        if (auth()->user()->hasRole('root') or auth()->user()->hasRole('moderator'))
        {
            $result = $this->application_crud->read_application();

            return response()->json([
                'result' => 'OK',
                'filter_status' => $result['status'],
                'filter_date' => $result['date'],
                'all_applications' => $result['all_applications'],
            ]);
        }
        else
            return response()->json([
                'result' => 'OK',
                'message' => 'У вас недостаточно прав.',
            ]);
    }
}
