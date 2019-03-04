<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use SocialiteProviders\Manager\ServiceProvider;
use App\User;
use Auth;

class SocialAuthController extends Controller
{
    public function callback()
    {
        $user = $this->createOrGetUser(Socialite::driver('twitch'));
        auth()->login($user);

        return redirect()->to('/streamers');
    }

    public function redirect()
    {
        return Socialite::driver('twitch')->redirect();
    }

    private function createOrGetUser(\SocialiteProviders\Twitch\Provider $provider)
    {
        $auth_user = $provider->user();

        $user = User::whereTwitchId($auth_user->getId())
            ->first();

        if(!$user) {
            $user = User::create([
                'email' => $auth_user->getEmail(),
                'username' => $auth_user->getNickname(),
                'twitch_id' => $auth_user->getId(),
                'avatar' => $auth_user->getAvatar(),
            ]);
        }

        return $user;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
