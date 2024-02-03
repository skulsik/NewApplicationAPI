<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Services\Api\CRUD\ApplicationCRUD;
use App\Services\Api\Validator\ApplicationCreateValidator;
use App\Services\Api\Validator\ApplicationUpdateValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->application_crud = new ApplicationCRUD();
    }

    /**
     * Метод получения csrf токена
     * GET
    */
    public function get_csrf_token()
    {
        return response()->json([
            'result' => 'OK',
            'csrf_token' => csrf_token(),
        ]);
    }

    /**
     * Метод создания заявки
     * POST
    */
    public function create_application(Request $request)
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
            try {
                $this->application_crud->create_application($request);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = $e->getMessage();
            }

            return response()->json([
                'result' => 'OK',
                'application_create' => $message,
            ]);
        }
    }

    /**
     * Метод получения всех заявок
     * GET
     */
    public function get_all_applications()
    {
        $result = $this->application_crud->read_application();

        return response()->json([
            'result' => 'OK',
            'filter_status' => $result['status'],
            'filter_date' => $result['date'],
            'all_applications' => $result['all_applications'],
        ]);
    }

    /**
     * Метод получения одной заявки
     * GET
     */
    public function get_application($id)
    {
        $application = DB::table('application_models')->find($id);

        return response()->json([
            'result' => 'OK',
            'application' => $application,
        ]);
    }

    /**
     * Метод записи комментария и завершение заявки
     * PATCH
     */
    public function completion_application(Request $request, $id)
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
            try {
                $application = $this->application_crud->completion_application($request, $id);
            } catch (\Illuminate\Database\QueryException $e) {
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
}
