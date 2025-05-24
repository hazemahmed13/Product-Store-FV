<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class ResetPasswordController extends Controller
{
    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        // Check if token exists and is valid
        $reset = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid password reset token.']);
        }

        if (Carbon::parse($reset->created_at)->addHours(24)->isPast()) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Password reset token has expired.']);
        }

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $reset->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid password reset token.']);
        }

        if (Carbon::parse($reset->created_at)->addHours(24)->isPast()) {
            return back()->withErrors(['email' => 'Password reset token has expired.']);
        }

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        event(new PasswordReset($user));

        return redirect($this->redirectTo)
            ->with('status', 'Your password has been reset successfully!');
    }
} 












































