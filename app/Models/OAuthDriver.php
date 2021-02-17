<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OAuthDriver extends Model
{
    use HasFactory;

    protected $table = 'oauth_drivers';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'active'
    ];

    protected $hidden = [
    ];

    protected $guarded = [
        'id'
    ];
}
