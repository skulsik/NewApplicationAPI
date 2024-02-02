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
    public function read_application($get = false)
    {
        /** Фильтр - только незавершенные */
        $status = false;
        if (isset($_GET['status'])) $status = true;

        /** Фильтр - обратная сортировка по времени создания */
        $date = false;
        if (isset($_GET['date'])) $date = true;

        $all_applications = DB::table('application_models')->get();
        return $all_applications;
    }
}
