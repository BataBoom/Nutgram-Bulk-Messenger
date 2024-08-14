Telegram Bulk Messenger for Nutgram Laravel.

Requires:
- https://github.com/nutgram/nutgram
- https://github.com/laravel/laravel


```
$recipients = TelegramChat::All()->pluck('chat_id');

Create a Message:

$createMsg = TelegramSpamMsg::Create([
'title' => 'Your Newsletter',
'message' => 'some message',
'recipients' => json_encode($recipients->toArray()),
]);

Add Recipents to Queue:
foreach($recipients as $recipient)
{
  TelegramSpam::Create([
    'chat_id' => $recipient,
    'msg_id' => $createMsg->id,
  ]);
}

php artisan spam:telegram 1

```
