<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $socialAccounts = $user->socialAccounts;

        return view('profile.show', compact('user', 'socialAccounts'));
    }

    public function linkSocialAccount($provider)
    {
        if (!in_array($provider, ['facebook', 'github'])) {
            return redirect()->back()->with('error', 'Invalid social provider');
        }

        // Check if already linked
        if (Auth::user()->hasSocialAccount($provider)) {
            return redirect()->back()->with('info', ucfirst($provider) . ' account is already linked');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function unlinkSocialAccount($provider)
    {
        $socialAccount = Auth::user()->getSocialAccount($provider);

        if ($socialAccount) {
            $socialAccount->delete();
            return redirect()->back()->with('success', ucfirst($provider) . ' account unlinked successfully');
        }

        return redirect()->back()->with('error', ucfirst($provider) . ' account not found');
    }
} 