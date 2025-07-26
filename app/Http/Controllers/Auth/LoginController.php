<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use ReflectionObject;
use Twilio\Rest\Client;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    public function loginForm() {
        return view('login');
    }

    public function attemptLogin(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['success' => false, 'message' => 'Email atau password salah.']);
            }

            $otp = rand(100000, 999999);

            OtpVerification::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(2),
            ]);

            // $sid = "AC2b30e30d988e15b25958d5bc1927ff88";
            // $token = "4b6511d29d88a7f2868bd5f38663d2e6";

            $sid = "";
            $token = "";

            $twilio = new Client($sid, $token);
            $to = "whatsapp:+$user->phone";

            $message = $twilio->messages
            ->create($to, [
                "from" => "whatsapp:+14155238886",
                "body" => "Kode OTP kamu adalah $otp"
            ]);

            return response()->json(['success' => true, 'user_id' => $user->id]);
        } catch (\Exception $e) {
            dd($e);
            Log::error("Gagal kirim OTP WA: " . $e->getMessage());
        }
    }

    public function verifyOtp(Request $request)
    {
        $otp = OtpVerification::where('user_id', $request->user_id)
            ->where('otp', $request->otp_code)
            ->where('is_verified', false)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otp) {
            return redirect()->back()->with('error', 'Kode OTP salah atau sudah kadaluarsa.');
        }

        $otp->update(['is_verified' => true]);

        Auth::loginUsingId($request->user_id);

        return redirect('/home');
    }

}
