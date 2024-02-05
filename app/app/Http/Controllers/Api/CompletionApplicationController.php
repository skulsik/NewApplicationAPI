<?php

namespace App\Http\Controllers\Api;

use App\Mail\SendMail;
use App\Services\Api\Validator\ApplicationUpdateValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CompletionApplicationController extends ApiController
{
    /**
     * @OA\Patch(
     *     path="/api/application/completion_application/{id}",
     *     summary="Андпоинт - запись комментария к заявке, отправка сообщения на почту.",
     *     description="Добавляет комментарий к заявке, добавляет статус - завершено, отправляет комментарий на почту создателя заявки. Возвращает ошибки или сообщение о успешном добавлении комментария в заявку и сам объект заявки.",
     *     @OA\Parameter(
     *         name="comment",
     *         in="query",
     *         description="Комментарий.",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Заявка создана."),
     *     @OA\Response(response="401", description="Неверные учетные данные.")
     * )
     */
    public function completion_application(Request $request, $id)
    {
        if (auth()->user()->hasRole('root') or auth()->user()->hasRole('moderator'))
        {
            /** Валидация поля comment */
            $comment_validator = new ApplicationUpdateValidator($request);
            $comment_validator->run_validator();
            $error = $comment_validator->error_validator();

            /** Если есть ошибки валидации, отдает клиенту */
            if ($error)
            {
                return ['result' => 'error', 'errors' => $error];
            }
            else
            {
                /** Обновление заявки в бд.
                 * Если есть ошибка, отдает ее в ответ.
                 */
                $message = 'Заявка успешно обновлена!';
                try
                {
                    $application = $this->application_crud->completion_application($request, $id);
                }
                catch (\Illuminate\Database\QueryException $e)
                {
                    $message = $e->getMessage();
                }

                /** Отправляет комментарий по заявке на почту клиента */
                Mail::to($application->email)
                    ->send(new SendMail($application->name, $application->comment, $application->id));

                return response()->json([
                    'result' => 'OK',
                    'application_update' => $message,
                    'application' => $application,
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
