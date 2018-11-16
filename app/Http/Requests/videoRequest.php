<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class videoRequest extends FormRequest
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
      $rules =[
         'files.*.quality'=>'required',
         'files.*.type'=>'required',
         'files.*.imdblink'=>'required'
      ];
      foreach ($this->files as $video) {
          $rules[$video]='required';
      }

     
        return $rules;
    }
}
