<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Api\Admin\AddAssignmentRight;
use App\Services\Api\Validator\AssignmentRightValidator;
use Illuminate\Http\Request;

class AssignmentRight extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/admin/assignment_right",
     *     summary="Андпоинт - присвоение прав зарегистрированному пользователю.",
     *     description="Присваивает права зарегистрированному пользователю (root, moderator). Возвращает сообщение.",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Индификатор зарегистрированного пользователя.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="role",
     *         in="query",
     *         description="Право - присвоить пользователю..",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Заявка создана."),
     *     @OA\Response(response="401", description="Неверные учетные данные.")
     * )
     */
    public function assignment_right(Request $request)
    {
        if (auth()->user()->hasRole('root'))
        {
            /** Валидация полей (id, role) */
            $application_validator = new AssignmentRightValidator($request);
            $application_validator->run_validator();
            $error = $application_validator->error_validator();

            /** Если есть ошибки валидации, отдает клиенту */
            if ($error)
            {
                return ['result' => 'error', 'errors' => $error];
            }
            else
            {
                /** Запись заявки в бд.
                 * Если есть ошибка, отдает ее в ответ.
                 */
                $message = 'Права успешно присвоены!';
                try
                {
                    new AddAssignmentRight($request);
                }
                catch (\Illuminate\Database\QueryException $e)
                {
                    $message = $e->getMessage();
                }

                return response()->json([
                    'result' => 'OK',
                    'message' => $message,
                ]);
            }
        }
        else
            return response()->json([
                'result' => 'OK',
                'message' => 'У вас недостаточно прав.',
            ]);
    }
}
