<?php


namespace App\Classes;




use App\Enums\General\ExtensionTypes;
use App\Enums\General\FileTypes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileClass
{
    public static function uploadFile($file,$fileType,$userId)
    {
        try {
            $extension=$file->extension();
            $storageType=FileClass::determineAttachmentType($extension);
            $filename = StringConstant::getFileName($fileType,$userId,$extension);
            $shortPath= StringConstant::getShortPath($storageType,$fileType);
            $path = StringConstant::getFullPath($shortPath);
            $file->move($path, $filename);
            return  $shortPath . $filename;
        }
        catch (\Exception $e)
        {
            return null;
        }

    }

    public static function determineAttachmentType($extension)
    {
        if($extension==ExtensionTypes::mp4 || $extension == ExtensionTypes::mov)
            return FileTypes::video;
        else return FileTypes::photo;
    }

    public static function getExtensionFromUrl($url)
    {
        $extension='';
        for($i=strlen($url)-1;$i>=0;$i--)
        {
            if($url[$i]=='.')
                for($j=$i+1;$j<strlen($url);$j++)
                    $extension=$extension.$url[$j];
        }
        return $extension;
    }
    public static function checkExistFile($path)
    {
        return File::exists(public_path().$path);
    }

    public static function getFileFromUrl($filename, $fileUrl, $storage)
    {
        $filePath = $storage . $filename;
        $file = public_path().$filePath;
        file_put_contents($file, file_get_contents($fileUrl));
        return $filePath;
    }
    public static function deleteFile($filePath)
    {
        if(FileClass::checkExistFile($filePath))
        return File::delete(public_path($filePath));
    }
}
