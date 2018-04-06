<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ArticlesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //перевірка чи юзер має право на збереження іинформації
        return Auth::user()->authorize('Add_Articles');
    }

    //переоприділяємо
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias','unique:articles|max:255', function ($input){
            //для врахування редагуваання статті
            //dd($this->route());
            if($this->route()->hasParameter('article') && $this->route()->parameter('article')->alias == $input->alias){
                //якщо параметр існує та значення alias == вже існуючому alias то валідацію робити не портібно (вернем FALSE)
                return FALSE;
            }

            //return message if rules not fulfilled- для запису нової статті
            return !empty($input->alias);
        });

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'text' => 'required|string',
            'desc' => 'required|string',
            'keywords' => 'required|max:255',
            'meta_desc' => 'required|max:255',
            'category_id' => 'required|integer'

        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле не должно быть пустым!',
            'unique' => 'Поле существует в базе данных!'
        ];
    }
}
