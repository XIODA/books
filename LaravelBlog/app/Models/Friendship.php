<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
    ];
    // 送出請求的使用者
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => '未知的使用者',
        ]);
    }

    // 接收請求的使用者
    public function receiver()
    {
        return $this->belongsTo(User::class, 'friend_id')->withDefault([
            'name' => '未知的使用者',
        ]);
    }
}
