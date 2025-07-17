<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WhatsappHelper
{
    public static function sendOtp($phone, $otp)
    {
        $message = "Kode OTP kamu: $otp (hanya berlaku 3 menit)";
        Http::post('https://api.chat-api.com/instance12345/message?token=your_token', [
            'phone' => $phone,
            'body'  => $message
        ]);
    }
}
