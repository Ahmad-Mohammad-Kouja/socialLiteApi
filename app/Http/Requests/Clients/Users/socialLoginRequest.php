<?php

namespace App\Http\Requests\Clients\Users;

use App\Classes\ResponseHelper;
use App\Enums\Social\SocialProviderTypes;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class socialLoginRequest extends FormRequest
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
            'provider' => ['required',new EnumKey(SocialProviderTypes::class)],
            'social_token' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            ResponseHelper::errorMissingParameter($validator->getMessageBag())
        );

    }
}
