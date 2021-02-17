<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OAuthUser extends Model
{
    use HasFactory;

    protected $table = 'oauth_users';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $guarded = [
        'id',
        'user_id',
        'oauth_id',
        'access_token',
        'refresh_token',
        'oauth_driver_id'
    ];


    public function oauthDriver() {
        return $this->hasOne(OAuthDriver::class, 'oauth_driver_id', 'id');
    }
}
