<?php

namespace App\Services\Api\Validator;

use Illuminate\Support\Facades\Validator;

class ApiLoginValidator
{
    /** Формирует правила и сообщения о ошибках */
    public function __construct($request)
    {
        $this->request = $request;
        /** Правила проверки */
        $this->rules = array(
            'email' => "required|string|max:50|email:strict",
            'password' => "required"
        );

        /** Кастомные сообщения */
        $this->messages = [
            'email.required' => 'Поле (email) не должно быть пустым.',
            'email.string' => 'Поле (email) типа string.',
            'email.max' => 'В поле (email), можно ввести не более 50 символов',
            'email.email' => 'Вы неправильно ввели адрес электронной почты.',

            'password.required' => 'Поле (password) не должно быть пустым.',
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
