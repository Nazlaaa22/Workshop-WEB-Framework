<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'id_google' => $googleUser->id,
                'password' => bcrypt('google_login')
            ]
        );

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->save();

        // 🔥 Kirim OTP ke email
        Mail::raw("Kode OTP login kamu adalah: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Kode OTP Login Laravel');
        });

        session(['otp_user_id' => $user->id]);

        return redirect('/otp');
    }

    // ✅ INI HARUS ADA DI DALAM CLASS
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $user = User::find(session('otp_user_id'));

        if (!$user) {
            return redirect('/login');
        }

        if ($user->otp == $request->otp) {

            Auth::login($user);

            $user->otp = null;
            $user->save();

            session()->forget('otp_user_id');

            return redirect('/home');
        }

        return back()->with('error', 'OTP salah');
    }
}