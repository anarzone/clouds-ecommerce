<?php

namespace App\Models\Stuff;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use HasFactory, HasRoles;

    protected $guard_name = 'web';

    protected $table = 'admin_users';
    protected $fillable = [
        'name',
        'phone',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }


}
