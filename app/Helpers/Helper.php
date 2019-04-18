<?php

namespace App\Helpers;

use Session;
use Auth;
use App;

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
}
