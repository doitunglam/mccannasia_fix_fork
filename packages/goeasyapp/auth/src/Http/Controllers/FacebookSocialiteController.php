<?php

namespace Goeasyapp\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialUser;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;
use Symfony\Component\Uid\Uuid;

class FacebookSocialiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToFB()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $finduser = User::where('social_id', $user->id)->first();

        if ($finduser) {
            Auth::login($finduser);

            return redirect('/dashboard');

        } else {
            $socialuser = SocialUser::create([
                'social_id' => $user->id,
                'social_type' => 'facebook'
            ]);
            //            $newUser = User::create([
//                return redirect('/');
//                'phone' =>null,
//                'name' => $user->name,
//                'email' => $user->email,
//                'social_id' => $user->id,
//                'social_type' => 'facebook',
//                'password' => encrypt('12345678')
//            ]);
//
//            Auth::login($newUser);
            $userid = $socialuser->id;
            return redirect()->route('register', ['name' => $user->name, 'email' => $user->email, 'social_id' => $userid, 'social_type' => 'facebook']);
        }

    }

}