<?php

namespace App\Http\Controllers;

use App\Models\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function form()
    {
        return view('auth.verify_otp');
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required']);
        $user = Auth::user();

        $record = OtpVerification::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'OTP salah atau kedaluwarsa.']);
        }

        $record->update(['is_verified' => true]);
        session(['otp_verified' => true]);

        return redirect('/home');
    }

}
