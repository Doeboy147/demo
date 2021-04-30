<?php


namespace App\Utilities;

use Illuminate\Support\Facades\Http;
use App\Models\Sms;

class SendSMS
{
    private $url;

    private $account;

    private $username;

    private $password;

    private $phoneNumber;

    private $message;

    public function __construct($phoneNumber, $message)
    {
        $this->url         = "https://sms.connect-mobile.co.za/submit/single/";
        $this->account     = "online.makola.t";
        $this->username    = "online.makola.t";
        $this->password    = "75d54d89";
        $this->phoneNumber = $phoneNumber;
        $this->message     = urlencode($message);
        $this->send();
    }

    public function send()
    {
        $response = Http::get($this->url . '?username=' . $this->username . '&password=' . $this->password . '&account=' . $this->account . '&da=' . substr_replace($this->phoneNumber,'27',0,1) . '&ud=' . $this->message);
        if (strpos($response->body(),'Accepted')){
            Sms::where('phone_number', $this->phoneNumber)->update([
                'status' => 1
            ]);
        }
        return $response->body();
    }
}