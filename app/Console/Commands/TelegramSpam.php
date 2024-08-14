<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;
use App\Models\TelegramChat;
use App\Models\TelegramSpam as TGS;
use App\Models\TelegramSpamMsg;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TelegramSpam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:telegram {message_id}';

    public $timeout = 5;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'spam telegram';

    public function getMessageID()
    {
        return $this->argument('message_id');
    }

    public function fetchChats()
    {
        return TGS::Where('msg_id', $this->getMessageID())->where('sent', false)->get();
    }

    public function fetchMessage()
    {
        return TelegramSpamMsg::Find($this->getMessageID())->message;
    }

    public function parseViewMessage(string $view, array $values = []): string
    {
        return rescue(function () use ($view, $values) {
            return (string)Str::of(view("messages.$view", $values)->render())
                ->replaceMatches('/\r\n|\r|\n/', '')
                ->replace(['<br>', '<BR>'], "\n");
        }, 'messages.'.$view, false);
    }



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot = new Nutgram($_ENV['TELEGRAM_TOKEN']);
        $text = $this->fetchMessage();

        foreach($this->fetchChats() as $chat) {
            
            if($bot->sendMessage(
                text: $this->parseViewMessage('spam', [
                        'dearUser' => "Dear ".$chat->chat->user->name.",",
                    ]),
                chat_id: $chat->chat_id,
                parse_mode: ParseMode::HTML,
            )) {
                $chat->update(['sent' => true]);
                $this->line('SENT: ' . $chat->chat_id.' - '.$chat->chat->user->name);
                }
        
            sleep($this->timeout);
        }
    }
}
