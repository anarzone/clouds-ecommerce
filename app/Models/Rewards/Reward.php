<?php

namespace App\Models\Rewards;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;
    protected $table = 'rewards';
    protected $fillable = [
        'total',
        'customer_id'
    ];

    public function logs(){
        return $this->hasMany(RewardLog::class, 'reward_id');
    }
}
