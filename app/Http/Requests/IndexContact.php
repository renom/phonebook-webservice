<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexContact extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname' => 'max:135',
            'surname' => 'max:45',
            'name' => 'max:45',
            'patronymic' => 'max:45',
            'updated_at' => 'string',
            'created_at' => 'string',
            'phone' => 'max:45',
            'sort' => 'in:id,-id,fullname,-fullname,surname,-surname,name,-name,patronymic,-patronymic,updated_at,-updated_at,created_at,-created_at',
        ];
    }
}
