<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        // Validate provider
        if (!in_array($provider, ['facebook', 'github'])) {
            return redirect()->route('login')->with('error', 'Invalid social provider');
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong with ' . ucfirst($provider) . ' authentication');
        }
    }

    public function handleProviderCallback($provider)
    {
        // Validate provider
        if (!in_array($provider, ['facebook', 'github'])) {
            return redirect()->route('login')->with('error', 'Invalid social provider');
        }

        try {
            $socialUser = Socialite::driver($provider)->user();

            // Check if user already exists with this social account
            $socialAccount = SocialAccount::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if ($socialAccount) {
                // User exists, log them in
                Auth::login($socialAccount->user);
                return redirect()->intended('/home');
            }

            // Check if user exists with same email
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName() ?: $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(32)), // Random password
                    'email_verified_at' => now(),
                    'avatar' => $socialUser->getAvatar(),
                ]);
            }

            // Create social account record
            SocialAccount::create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'provider_token' => $socialUser->token,
                'provider_refresh_token' => $socialUser->refreshToken,
            ]);

            Auth::login($user);
            return redirect()->intended('/home');

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong with ' . ucfirst($provider) . ' authentication');
        }
    }
} 