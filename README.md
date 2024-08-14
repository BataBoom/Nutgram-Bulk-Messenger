Telegram Bulk Messenger for Nutgram Laravel.

Requires:
- https://github.com/nutgram/nutgram
- https://github.com/laravel/laravel


```
$recipients = TelegramChat::All()->pluck('chat_id');

Create a Message:

TelegramSpamMsg::Create([
'title' => 'Your Newsletter',
'message' => 'some message',
'recipients' => json_encode($recipients->toArray()),
]);

php artisan spam:telegram 1

```
