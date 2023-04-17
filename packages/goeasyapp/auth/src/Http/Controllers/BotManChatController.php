<?php

namespace Goeasyapp\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BotManChatController extends Controller
{
    public function invoke()
    {
        $botman = app('botman');
        $botman->hears('{message}', function($botman, $message) {
            if ($message == 'hello') {
                $this->askInfo($botman);
            }else{
                $botman->reply("Bạn muốn hỗ trợ gì ạ?");
            }
        });
        $botman->listen();
    }
    public function askInfo($botman)
    {
        $botman->ask('Hey There! How are you?', function(Answer $answer) {
            $ans = $answer->getText();
            $botman->say('Whats up '.$ans);
        });
    }
}
