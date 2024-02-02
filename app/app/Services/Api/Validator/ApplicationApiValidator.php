<?php

namespace App\Services\Api\Validator;

use App\Services\Validator\errors;
use Illuminate\Support\Facades\Validator;

/**
 * Проверка полей заявки с кастомными сообщениями о ошибках
 * @return errors
*/
class ApplicationApiValidator
{
    /** Формирует правила и сообщения о ошибках */
    public function __construct($request)
    {
        $this->request = $request;
        /** Правила проверки */
        $this->rules = array(
            'name' => "required|string|max:50",
            'email' => "required|string|max:50|email:strict",
            'message' => "required|string"
        );

        /** Кастомные сообщения */
        $this->messages = [
            'name.required' => 'Поле (name) не должно быть пустым.',
            'name.string' => 'Поле (name) типа string',
            'name.max' => 'В поле (name), можно ввести не более 50 символов',

            'email.required' => 'Поле (email) не должно быть пустым.',
            'email.string' => 'Поле (email) типа string.',
            'email.max' => 'В поле (email), можно ввести не более 50 символов',
            'email.email' => 'Вы неправильно ввели адрес электронной почты.',

            'message.required' => 'Поле (message) не должно быть пустым.',
            'message.string' => 'Поле (message) типа string.'
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
