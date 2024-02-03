<?php

namespace App\Services\Api\Validator;

use Illuminate\Support\Facades\Validator;

/**
 * Проверка поля comment заявки с кастомными сообщениями о ошибках
 * return errors
 */
class ApplicationUpdateValidator
{
    /** Формирует правила и сообщения о ошибках */
    public function __construct($request)
    {
        $this->request = $request;
        /** Правила проверки */
        $this->rules = array(
            'comment' => "required|string|max:255",
        );

        /** Кастомные сообщения */
        $this->messages = [
            'comment.required' => 'Поле (comment) не должно быть пустым.',
            'comment.string' => 'Поле (comment) типа string',
            'comment.max' => 'В поле (comment), можно ввести не более 255 символов',
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
