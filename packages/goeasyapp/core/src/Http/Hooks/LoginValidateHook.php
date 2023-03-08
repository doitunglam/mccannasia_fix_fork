<?php

namespace Goeasyapp\Core\Http\Hooks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Language;

class LoginValidateHook
{
    protected $routerLogin = "admin/login";
    protected $routerHome = "dashboard";
    protected $useModel;
    public function __construct(User $user)
    {
        $this->useModel = $user;

    }
    public function validate($request)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $request->validate([
            'email' => 'required',
            'password' => 'required',
//            'g-recaptcha-response' => ['required', new \App\Rules\ValidRecaptcha]
        ], [
                'email.required' => 'Số điện thoại không được để trống',
                'password.required' => 'Mật khẩu không được để trống',
            ]);
        $validator = Validator::make([], []);

        $user = $this->useModel::where('phone', $request->email)->first();
        if ($user && $user->status == 1) {
            $validator->errors()->add(
                'message',
                __trans($language, 'not_match_aaa', 'Tài khoản của bạn đã bị khóa.!')
            );
            return ['resuft' => false, 'validator' => $validator];
        }
        if ($user) {
            Auth::login($user);
            return ['resuft' => true];
        }
        $validator->errors()->add(
            'message',
            __trans($language, 'not_match', 'Tài khoản không đúng.!')
        );
        return ['resuft' => false, 'validator' => $validator];
    }
}