<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\CRUD\ApplicationCRUD;
use App\Services\Api\Validator\ApplicationApiValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $application_validator = new ApplicationApiValidator($request);
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
        $all_applications = $this->application_crud->read_application($_GET);

        return response()->json([
            'result' => 'OK',
            //'filter_status' => $status,
            //'filter_date' => $date,
            'all_applications' => $all_applications,
        ]);
    }
}
