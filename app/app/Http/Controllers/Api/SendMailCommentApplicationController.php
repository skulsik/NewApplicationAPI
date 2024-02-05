<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\ApplicationModel;
use App\Services\Api\Validator\ApplicationUpdateValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailCommentApplicationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/application/send_mail_comment_application/{id}",
     *     summary="Андпоинт - отправка сообщения на почту.",
     *     description="Отправляет сообщение на почту клиента.",
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
    public function send_mail_comment_application(Request $request, $id)
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
                $application = ApplicationModel::find($id);

                /** Отправляет комментарий по заявке на почту клиента */
                Mail::to($application->email)
                    ->send(new SendMail($application->name, $application->comment, $application->id));

                return response()->json([
                    'result' => 'OK',
                    'application_update' => 'Сообщение успешно отправлено клиенту ('.$application->name.').',
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
