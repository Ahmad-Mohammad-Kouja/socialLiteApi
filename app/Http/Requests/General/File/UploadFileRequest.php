<?php

namespace App\Http\Requests\General\File;

use App\Classes\ResponseHelper;
use App\Enums\General\ExtensionTypes;
use App\Enums\General\StorageTypes;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UploadFileRequest extends FormRequest
{


    protected $validator = \Illuminate\Support\Facades\Validator::class;
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
            'file' => ['required|mimes:jpg,jpeg,png,mp4,mov|max:2048'],
            'file_type' => ['required',new EnumValue(StorageTypes::class)]
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            ResponseHelper::errorMissingParameter($validator->getMessageBag())
        );
    }
}
