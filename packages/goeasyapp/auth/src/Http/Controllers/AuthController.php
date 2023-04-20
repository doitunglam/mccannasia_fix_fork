<?php

namespace Goeasyapp\Auth\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\LoginValidateHook;
use Goeasyapp\Core\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Language;

class AuthController extends Controller
{
    private $useHook;
    private $useRepository;
    protected $routerLogin = "admin/login";
    protected $routerHome = "admin/dashboard";
    public function __construct(LoginValidateHook $LoginValidateHook, UserRepository $UserRepository)
    {

        $this->useHook = $LoginValidateHook;
        $this->useRepository = $UserRepository;
    }

    public function store(Request $request)
    {

        $genderArray = ['Male', 'Female'];

        $request->validate([
            'username' => ['required', 'unique:users,name'],
            'email' => 'unique:users|email',
            'phone' => 'required|unique:users|numeric',
            'name' => 'required|string',
            'gender' => ['required', 'in:' . implode(',', $genderArray)],
            'password' => 'required',
            'repassword' => 'required|same:password',
            'parent_referral_code' => 'required',
            'g-recaptcha-response' => ['required', new \App\Rules\ValidRecaptcha],
        ], [
                'username.required' => 'Tên hiển thị không được để trống',
                'username.unique' => 'Tên đã tồn tại trên hệ thống',
                'email.unique' => 'Email đã tồn tại trên hệ thống',
                'email.email' => 'Email không hợp lệ',
                'phone.required' => 'Số điện thoại không được để trống',
                'phone.unique' => 'Số điện thoại đã tồn tại trên hệ thống',
                'phone.numeric' => 'Số điện thoại không hợp lệ',
                'name.required' => 'Họ tên không được để trống',
                'password.required' => 'Mật khẩu không được để trống',
                'repassword.required' => 'Nhập lại mật khẩu không được để trống',
                'repassword.same' => 'Nhập lại mật khẩu không khớp với mật khẩu',
                'g-recaptcha-response' => 'Captcha không được để trống',
                'parent_referral_code.required' => 'Mã giới thiệu là bắt buộc. Vui lòng liên hệ hỗ trợ online',
            ]);
        if ($request->type_ == 'nhanvien') {
            $r = 'staff';
        } else {
            $r = 'agency';
        }
        if ($request->email != '') {
            $check = User::where('email', $request->username)->first();
            if ($check) {
                return redirect()->back()
                    ->with('success', 'Email already exists in the system.');
            }
        }
        if ($request->phone != '') {
            $check = User::where('phone', $request->phone)->first();
            if ($check) {
                return redirect()->back()
                    ->with('success', 'Phone already exists in the system.');
            }
        }
        $model = new User;
        $lang = (session('introduce') ? session('introduce') : '');
        $model->name = $request->username;
        $model->url = $lang;
        if ($request->email != '') {
            $model->email = $request->email;
        } else {
            $model->email = time() . '@gmail,com';
        }
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->type = 'agency';
        if ($request->password != '')
            $model->password = bcrypt($request->password);

        if ($model->save()) {
            if (! empty($request->parent_referral_code)) {
                $parent_user = User::where('referral_code', $request->parent_referral_code)->first();
                if ($parent_user != null) {
                    $referral_bonus = Setting::where('key', 'referral_bonus')->first()->value ?? 50000;
                    $parent_user->amount += $referral_bonus;
                    $parent_user->save();
                    $model->parent_referral_code = $request->parent_referral_code;
                    $model->save();
                }
            }
        }
        //        $model->save();

        if ($request->file('image')) {
            $file_name = $request->file('image')->getClientOriginalName();
            $end = explode('.', $file_name);
            $index_ = count($end) - 1;
            $file_name = time() . '.' . $end[$index_];
            $request->file('image')->move('upload/user/' . $model->id, $file_name);
            $model->img = 'upload/user/' . $model->id . '/' . $file_name;
        }

        $model->save();
        return redirect()->intended('admin/login')
            ->with('success', 'Đăng ký thành công!');
    }

    public function register()
    {
        return view('auth::register');
    }
    public function login()
    {
        return view('auth::login');
    }
    public function customLogin(Request $request)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $check = $this->useHook->validate($request);
        session(['login-current' => 'true']);
        if ($check['resuft'])
            return redirect()->intended($this->routerHome)->with('success', __trans($language, 'success', 'Success!'));
        return redirect()->back()->withErrors($check['validator'])->withInput();
    }
    public function customSignout(Request $request)
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
