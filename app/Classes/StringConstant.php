<?php


namespace App\Classes;


class StringConstant
{

	public static $defaultUserImage='/media/photo/user/user11589406136.png';
		
    public static function getShortPath($storageType,$fileType)
    {
        return '/media/'.$storageType.'/'.$fileType.'/';
    }

    public static function getFileName($fileType,$userId,$fileExtension)
    {
       return ''.$fileType.''.$userId. time() . '.' . $fileExtension;
    }

    public static function getFullPath($shortPath)
    {
        return public_path() . $shortPath;
    }

}
