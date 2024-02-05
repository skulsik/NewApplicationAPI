<?php

namespace App\Services\Api\Validator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AssignmentRightValidator
{
    /** Формирует правила и сообщения о ошибках */
    public function __construct($request)
    {
        $this->request = $request;
        /** Правила проверки */
        $this->rules = array(
            'id' => "required|integer",
            'role' => [
                'required',
                'string',
                Rule::in(['root', 'moderator']),
            ],
        );

        /** Кастомные сообщения */
        $this->messages = [
            'id.required' => 'Поле (id) не должно быть пустым.',
            'id.integer' => 'Поле (id) типа integer.',

            'role.required' => 'Поле (role) не должно быть пустым.',
            'role.string' => 'Поле (role) типа string.',
            'role.in' => 'Поле может иметь значения: root, moderator.'
        ];
    }

    /** Валидация */
    public function run_validator()
    {
        $this->validator = Validator::make($this->request->all(), $this->rules, $this->messages);
    }

    /** Если ошибки, возвращает их */
    public function error_validator()
    {
        if ($this->validator->fails()) {
            return $this->validator->errors();
        }
    }
}
