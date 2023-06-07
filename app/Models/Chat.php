<?php

namespace App\Models;

use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'chatNo',
        'message_id',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function message(){
        return $this->belongsTo(Message::class);
    }
}
