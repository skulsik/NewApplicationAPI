<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\CRUD\ApplicationCRUD;


class ApiController extends Controller
{
    public function __construct()
    {
        $this->application_crud = new ApplicationCRUD();
    }
}
