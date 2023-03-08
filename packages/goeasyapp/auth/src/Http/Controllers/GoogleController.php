<?php

namespace Goeasyapp\Auth\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\SocialUser;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $finduser = User::where('social_id', $user->id)->first();

        if ($finduser) {

            Auth::login($finduser);

            return redirect('/dashboard');

        } else {
            $socialuser = SocialUser::create([
                'social_id' => $user->id,
                'social_type' => 'google'
            ]);
            //
            $userid = $socialuser->id;
            return redirect()->route('register', ['name' => $user->name, 'social_id' => $userid, 'social_type' => 'google']);
        }
    }
}