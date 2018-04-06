<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //окрема провірка перед валідацією
        return Auth::user()->can('Add_Portfolio');
    }

   public function getValidatorInstance()
   {
      $validator = parent::getValidatorInstance();
       $validator->sometimes('alias','unique:articles|max:255', function ($input){

          return !empty($input->alias);
       });
       return $validator;
   }


    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'customer' => 'required|max:50',
            'filter_id' => 'required|integer',
            'text'=>'required|string'
        ];
    }
}
