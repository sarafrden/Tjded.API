<?php
namespace App\Core\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Utilities {

    public static function wrap($data)
    {
        return response()->json($data, 200);
    }

    public static function wrapStatus($data, int $httpCode)
    {
        return response()->json($data, $httpCode);
    }

    /**
     * return the ID of user that created this record.
     * @param $guard
     * @return mixed
     */
//    public static function createdBy()
//    {
//        if(Auth::guard('user')->user())
//        {
//             return Auth::guard('user')->user()->id();
//        }
//        return false;
//    }



    /**
     * uploading and storing photos and return its path
     * @param UploadedFile $file
     * @param $filePath
     * @return string
     */
    public static function upload($file, $filePath)
    {
        return (string)$file->store($filePath, 'public');
    }

    /**
     * uploading multiple photos and store them then storing their paths to the database
     * @param $images
     * @param $filePath
     * @return Collection
     */
    public static function uploadMultiImages($images, $filePath)
    {
        $countOfImages = 0;
        $storedImages = collect();
        foreach ($images as $image)
        {
            $storedImages->push([
                'id' => $countOfImages++,
                'path' => ($path = Utilities::upload($image, $filePath)),
            ]);
        }
        return $storedImages;
    }

    /**
     * get logged admin ID
     * @return mixed
     */
    public static function getAdminID()
    {
        if(Auth::guard('admin')->user())
        {
            return Auth::guard('admin')->user()->id();
        }
        return false;
    }

    /**
     * get logged merchant ID
     * @return mixed
     */
    public static function getMerchantID()
    {
        if(Auth::guard('merchant')->user())
        {
            return Auth::guard('merchant')->user()->id();
        }
        return false;
    }

}
