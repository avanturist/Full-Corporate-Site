<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenusRequest extends FormRequest
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
            'title'=>'required|max:15',
            'path' => 'required|url',
            'parent' => 'required|integer'

        ];
    }

    public function messages(){
        return [
            'required' => 'Поле не должно быть пустым',
            'url' => 'Поле должно соответствовать правилам URL'

        ];
    }
}
