<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\Validator\ApplicationCreateValidator;
use Illuminate\Http\Request;

class CreateApplicationController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/api/application/create_application",
     *     summary="Андпоинт - создания заявки.",
     *     description="Создает заявку. Возвращает сообщение: о ошибках или успешном создании заявки.",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Имя клиента.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Электронная почта клиента.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="message",
     *         in="query",
     *         description="Сообщение клиента.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Заявка создана."),
     *     @OA\Response(response="401", description="Неверные учетные данные.")
     * )
     */
    public function create_application(Request $request)
    {
        if (auth()->user()->hasRole('root') or auth()->user()->hasRole('moderator'))
        {
            /** Валидация полей (name, email, message) */
            $application_validator = new ApplicationCreateValidator($request);
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
                $message = 'Заявка успешно создана!';
                try
                {
                    $this->application_crud->create_application($request);
                }
                catch (\Illuminate\Database\QueryException $e)
                {
                    $message = $e->getMessage();
                }

                return response()->json([
                    'result' => 'OK',
                    'application_create' => $message,
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
