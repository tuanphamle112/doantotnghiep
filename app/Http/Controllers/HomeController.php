<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

use App\Helpers\Helper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function changeLanguage(Request $request)
    {
        $lang = $request->language;
        
        $language = config('app.locale');

        if ($lang == 'en') {
            $language = 'en';
        }
        
        if ($lang == 'vi') {
            $language = 'vi';
        }

        Helper::setLanguage($language);

        return redirect()->back();
    }
}
