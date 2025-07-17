<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = ['user_id', 'otp', 'expires_at', 'is_verified'];


}
