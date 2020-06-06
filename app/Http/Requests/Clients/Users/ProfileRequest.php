<?php

namespace App\Http\Requests\Clients\Users;

use App\Classes\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_id' => ['nullable','integer',Rule::exists('users','id')->where('deleted_at',null)]
        ];
    }


    public function failedValidation(Validator $validator)
    {
        if(strpos($validator->errors(),'The selected user id is invalid'))
            throw new HttpResponseException(
                ResponseHelper::isEmpty('data not found')
            );
        throw new HttpResponseException(
            ResponseHelper::errorMissingParameter('missing param')
        );
    }
}
