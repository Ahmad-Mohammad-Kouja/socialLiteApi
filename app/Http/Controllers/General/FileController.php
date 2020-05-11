<?php

namespace App\Http\Controllers\General;



use App\Classes\FileClass;
use App\Classes\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\General\File\UploadFileRequest;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public  function upload(UploadFileRequest $request)
    {
        $user=Auth::user();
        $path=FileClass::uploadFile($request->file('file'),$request->get('file_type'),$user->id);
        if(empty($path))
            return ResponseHelper::isEmpty('uploading fail');
        return ResponseHelper::select($path);
    }

}
