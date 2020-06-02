<?php

namespace App\Http\Requests\Social\FriendShips;

use App\Classes\ResponseHelper;
use App\Enums\Social\FriendShipTypes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class deleteFriendShipRequest extends FormRequest
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
                 'receiver_id' => ['required',Rule::exists('users')->where('deleted_at',null),'integer']

        ];
    }

    public function failedValidation(Validator $validator)
    {
        if(strpos($validator->errors(),'The selected receiver  id is invalid'))
            throw new HttpResponseException(
                ResponseHelper::isEmpty('data not found')
            );
        throw new HttpResponseException(
            ResponseHelper::errorMissingParameter()
        );
    }
}
