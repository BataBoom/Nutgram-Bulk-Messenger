<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TelegramChat extends Model
{
    use HasFactory;

    protected $table = 'telegram_chats';
    protected $guarded = [];
    protected $primaryKey = 'chat_id';
    public $incrementing = false;

    // Relationship To User
    public function user() {
        return $this->belongsTo(User::class, 'user_id','name');
    }

    public function reboots() {
        return $this->hasMany(Reboot::class, 'chat_id','chat_id')->latest('created_at');
    }

    public function requests() {
        return $this->hasMany(RequestEvent::class, 'chat_id','chat_id')->latest('created_at');
    }

    public function reports() {
        return $this->hasMany(ReportSlot::class, 'chat_id','chat_id')->latest('created_at');
    }

    public function tags() {
        return $this->hasMany(TelegramTag::class, 'user_id','user_id')->latest('created_at');
    }


    public function canReboot(): bool {

        if($this->chat_id === 5532381547) {
         return true;
        } else {
	 return $this->reboots->where('created_at', '>=', Carbon::today())->count() > 4 ? false : true; 
	}
    }

    public function getRebootLimitAttribute()
    {
        return "Daily limit reached. Try again in " . number_format(now()->diffInMinutes($this->reboots->first()->created_at->addHours(24)) / 60, 2) . " hours";
    }
}
