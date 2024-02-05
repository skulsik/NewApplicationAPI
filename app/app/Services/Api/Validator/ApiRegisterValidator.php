<?php

namespace App\Services\Api\Validator;

use Illuminate\Support\Facades\Validator;

class ApiRegisterValidator
{
    /** Формирует правила и сообщения о ошибках */
    public function __construct($request)
    {
        $this->request = $request;
        /** Правила проверки */
        $this->rules = array(
            'name' => "required",
            'email' => "required|string|max:50|email:strict|unique:users",
            'password' => "required|confirmed"
        );

        /** Кастомные сообщения */
        $this->messages = [
            'name.required' => 'Поле (name) не должно быть пустым.',

            'email.required' => 'Поле (email) не должно быть пустым.',
            'email.string' => 'Поле (email) типа string.',
            'email.max' => 'В поле (email), можно ввести не более 50 символов',
            'email.email' => 'Вы неправильно ввели адрес электронной почты.',
            'email.unique' => 'Пользователь с таким электронным адресом уже существует.',

            'password.required' => 'Поле (password) не должно быть пустым.',
            'password.confirmed' => 'Пароли отличаются.'
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
