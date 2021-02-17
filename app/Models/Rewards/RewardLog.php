<?php

namespace App\Models\Rewards;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardLog extends Model
{
    use HasFactory;
    protected $table = 'reward_logs';

    protected $fillable = [
        'name',
        'amount',
        'reward_id'
    ];
}
