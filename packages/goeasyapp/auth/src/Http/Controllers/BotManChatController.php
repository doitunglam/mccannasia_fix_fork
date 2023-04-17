<?php

namespace Goeasyapp\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class BotManChatController extends Controller
{
    public function invoke()
    {
        $botman = app('botman');
        $botman->hears('{message}', function($botman, $message) {
            if ($message == 'hello') {
            $this->askInfo($botman);
            }
            else if ($message == '/list') {
                $str = $this->getAgencyAndCode();
                $botman->reply($str);
            }else{
                $botman->reply("Type '/list' to get all agency and code");
            }
        });
        $botman->listen();
    }
    public function getAgencyAndCode() {
        $user = User::where('type', 'agency')->where('referral_code', '!=', null)
        ->select('name', 'referral_code')->get();
        $str = '';
        foreach ($user as $u) {
            $str .= $u->name . ' - ' . $u->referral_code . PHP_EOL;
        }
        return $str;
    }
    public function askInfo($botman)
    {
        $botman->ask('Hey There! How are you?', function(Answer $answer) {
            $ans = $answer->getText();
            $botman->say('Whats up '.$ans);
        });
    }
}
