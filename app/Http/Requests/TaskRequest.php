<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
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
        switch ( $this->method() ){
            case 'POST':
                return [
                    'title'         => 'required|max:255',
                    'description'   => 'required|max:500',
                    'user'          =>  'required|email|max:190|exists:users,email',
                ];
                break;
        }
    }

    public function failedValidation(ValidationValidator $validator) {
        $message = $validator->errors()->first();
        throw new HttpResponseException( response()->json([
            'response'    => $message,
            'status'      => false,
            'code'        => 500,
        ]));
    }
}
