<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;  
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Constants\Constants;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }


    public function failedValidation(Validator $validator)
    {
        $collection = collect($validator->errors())->flatten(1);
        $message = collect(["message" => $collection]);
        throw new HttpResponseException(
            response()->json( $message,Constants::SERVER_STATES['unprocessable'])
        );
    }
}
