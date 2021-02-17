<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpAuthentication extends Model
{
    use HasFactory;

    const EXPIRED = 1;
    const ACTIVE = 0;

    protected $table = 'otp_authentication';

    protected $fillable = [
        'otp',
        'email',
        'token',
        'expired',
    ];
}
