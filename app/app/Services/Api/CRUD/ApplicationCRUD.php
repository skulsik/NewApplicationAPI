<?php

namespace App\Services\Api\CRUD;

use App\Models\ApplicationModel;
use Illuminate\Support\Facades\DB;

/** Create Read Update Delete */
class ApplicationCRUD
{
    /** Создание заявки Create */
    public function create_application($request)
    {
        $application = new ApplicationModel();
        $application->name = $request->name;
        $application->email = $request->email;
        $application->message = $request->message;
        $application->save();
    }

    /** Создание заявки Create */
    public function read_application()
    {
        /** Фильтр
         * Если фильтр неуказан выведет все заявки (завершенные и незавершенные)
         * status = false - запрос на незавршенные заявки
         * status = true - запрос на завершенные заявки
         */
        $result['status'] = 'all';
        $status_query = '';
        if (isset($_GET['status']))
        {
            $result['status'] = $_GET['status'];
            $status_query = "WHERE status = '".$result['status']."'";
        }

        /** Фильтр - обратная сортировка по времени создания */
        $result['date'] = 'false';
        $date_query = '';
        if (isset($_GET['date']))
        {
            $result['date'] = 'true';
            $date_query = " DESC";
        }

        $result['all_applications'] = DB::select("SELECT * FROM application_models ".$status_query." ORDER BY created_at".$date_query.";");
        return $result;
    }

    /** Комментарий и завершение заявки Update */
    public function completion_application($request, $id)
    {
        $application = ApplicationModel::find($id);
        $application->comment = $request->comment;
        $application->status = true;
        $application->updated_at = now();
        $application->save();
        return $application;
    }
}
