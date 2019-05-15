<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

use Session;
use Auth;
use App;
use Storage;

class Helper
{
    public static function getCurrentLanguage()
    {
        return Session::get('language', config('app.locale'));
    }

    public static function setLanguage($lang = 'vi')
    {
        Session::put('language', $lang);
    }

    public static function setLocaleLanguage()
    {
        $language = self::getCurrentLanguage();
        switch ($language) {
            case 'en':
                $language = 'en';
                break;
            
            default:
                $language = 'vi';
                break;
        }
        App::setLocale($language);
    }

    public static function getContentFile($file)
    {
        return file_get_contents($file->getRealPath());
    }

    public static function putImageToUploadsFolder($fileName, $file)
    {
        $fileContent = self::getContentFile($file);
        
        Storage::disk('public_uploads')->put($fileName, $fileContent);
    }

    public static function deleteOldImage($file)
    {
        Storage::disk('public_uploads')->delete($file);
    }

    public static function deleteDirectory($folder)
    {
        Storage::disk('public_uploads')->deleteDirectory($folder);
    }

    public static function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $itemForpage = $items->forPage($page, $perPage);
        
        return new LengthAwarePaginator($itemForpage, $items->count(), $perPage, $page, $options, true);
    }
}
