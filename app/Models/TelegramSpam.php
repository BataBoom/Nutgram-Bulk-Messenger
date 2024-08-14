<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramSpam extends Model
{
    use HasFactory;

    protected $table = 'telegram_spam';
    protected $guarded = [];
    public $incrementing = true;
    public $timestamps = true;

    protected $casts = [
        'sent' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship To User/Chat
    public function chat() {
        return $this->belongsTo(TelegramChat::class, 'chat_id');
    }

    // Relationship To Message
    public function message() {
        return $this->belongsTo(TelegramSpamMsg::class, 'msg_id');
    }
}
