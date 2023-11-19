<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gamer_count',
        'reward_points',
    ];
}
