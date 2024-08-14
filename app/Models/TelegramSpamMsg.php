<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramSpamMsg extends Model
{
    use HasFactory;

    protected $table = 'telegram_spam_msgs';
    protected $guarded = [];
    public $incrementing = true;
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sha1_msg_hash = sha1($model->message);
        });
    }

    public function getRecipientsAttribute()
    {
        return json_decode($this->attributes['recipients']);
    }


}
