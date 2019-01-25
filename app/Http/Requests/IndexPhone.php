<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexPhone extends FormRequest
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
            'number' => 'max:45',
            'updated_at' => 'string',
            'created_at' => 'string',
            'fullname' => 'max:135',
            'surname' => 'max:45',
            'name' => 'max:45',
            'patronymic' => 'max:45',
            'sort' => 'in:id,-id,number,-number,updated_at,-updated_at,created_at,-created_at',
        ];
    }
}
