<?php

namespace App\Http\Requests\Social\Comments;


use App\Classes\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DeleteCommentRequest extends FormRequest
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
           'comment_id' => ['required',Rule::exists('comments','id')->where('deleted_at','NULL')]
        ];
    }


    public function failedValidation(Validator $validator)
    {
        if(strpos($validator->errors(),'The selected comment id is invalid'))
            throw new HttpResponseException(
                ResponseHelper::isEmpty('data not found')
            );
        throw new HttpResponseException(
            ResponseHelper::errorMissingParameter()
        );
    }
}
