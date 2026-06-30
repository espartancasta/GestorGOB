<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_thread_id',
        'user_id',
        'body',
    ];

    public function chatThread()
    {
        return $this->belongsTo(ChatThread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
