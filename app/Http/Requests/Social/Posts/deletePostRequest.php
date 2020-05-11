<?php

namespace App\Http\Requests\Social\Posts;


use App\Classes\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class deletePostRequest extends FormRequest
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
            'post_id' => ['required','integer',Rule::exists('posts','id')->where('deleted_at','NULL')],
        ];
    }


    public function failedValidation(Validator $validator)
    {

        if(strpos($validator->errors(),'The selected post id is invalid'))
            throw new HttpResponseException(
                ResponseHelper::isEmpty('data not found')
            );
        throw new HttpResponseException(
            ResponseHelper::errorMissingParameter('missing param')
        );
    }
}
