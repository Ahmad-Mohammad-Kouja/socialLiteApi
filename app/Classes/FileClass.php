<?php


namespace App\Classes;




use App\Enums\General\ExtensionTypes;
use App\Enums\General\FileTypes;

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
}
