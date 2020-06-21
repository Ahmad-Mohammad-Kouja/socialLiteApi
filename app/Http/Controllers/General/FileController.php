<?php

namespace App\Http\Controllers\General;



use App\Classes\FileClass;
use App\Classes\ResponseHelper;
use App\Enums\General\StorageTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\General\File\UploadFileRequest;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public  function upload(Request $request)
    {
        $validate = Validator::make($request->all() , [
            'file' => 'required|mimes:jpg,jpeg,png,mp4,mov',
            'file_type' => 'required',new EnumValue(StorageTypes::class)
        ]);
        if($validate->fails())
            return ResponseHelper::errorMissingParameter($validate->getMessageBag());
        $user=Auth::user();
        $path=FileClass::uploadFile($request->file('file'),$request->get('file_type'),$user->id);
        if(empty($path))
            return ResponseHelper::isEmpty('uploading fail');
        return ResponseHelper::insert($path);
    }

    public  function uploadUserImage(Request $request)
    {
        $validate = Validator::make($request->all() , [
            'file' => ['required|mimes:jpg,jpeg,png'],
        ]);
        if($validate->failed())
            return ResponseHelper::errorMissingParameter($validate->getMessageBag());
        $user=Auth::user();
        $path=FileClass::uploadFile($request->file('file'),StorageTypes::user,rand(1,100));
        if(empty($path))
            return ResponseHelper::isEmpty('uploading fail');
        return ResponseHelper::insert($path);
    }

}
