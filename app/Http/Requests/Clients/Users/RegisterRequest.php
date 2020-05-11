<?php

namespace App\Http\Requests\Clients\Users;

use App\Classes\ResponseHelper;
use App\Enums\Clients\GenderTypes;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'password' => ['required','min:4','max:14'],
            'name' => 'required',
            'email' => ['required', 'email',Rule::unique('users')],
            'gender' => ['required', new EnumValue(GenderTypes::class)],
        ];
    }

    public function failedValidation(Validator $validator)
    {

        if (strpos($validator->errors(), 'The email has already been taken'))
            throw new HttpResponseException(
                ResponseHelper::errorAlreadyExists('email already exist')
            );
        throw new HttpResponseException(
            ResponseHelper::errorMissingParameter('missing param')
        );

    }
}
