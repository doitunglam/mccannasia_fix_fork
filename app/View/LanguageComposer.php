<?php

namespace App\View;

use Illuminate\View\View;
use App\Models\Language;
use App\Models\Config;
use Illuminate\Support\Facades\Redirect;
use Auth;

class LanguageComposer
{
    public function compose(View $view)
    {
        $config = Config::where('status', 1)->get();
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $view->with('config', $config);
        $view->with('language', $language);
        if (Auth::check() && Auth::user()->status == 1) {
            Auth::logout();
            abort(Redirect::intended('admin/login')->with('success', 'Tài khoản đã bị khóa!'));
        }
    }
}