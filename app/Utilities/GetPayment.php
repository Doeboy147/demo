<?php


namespace App\Utilities;

use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Client;
use App\Models\Wallet;
use App\Models\User;

class GetPayment
{
    private $cm;

    private $client;

    public function __construct()
    {
        $this->cm = $this->getClientManager();

        $this->client = $this->cm->make([
            'host' => 'luqratemobile.co.za',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'username' => 'incomingmail@luqratemobile.co.za',
            'password' => 'ox#MiiZ3U',
            'protocol' => 'imap'
        ]);
        $this->client->connect();

    }

    public function getEmails()
    {
        $folders = $this->client->getFolders();

        foreach ($folders as $folder){
            $messages = $folder->messages()->all()->get();

            foreach ($messages as $message) {
                dd($message->getRawBody());
                $reference = preg_match('/\[Ref\](.*?)/s',$message->getTextBody, $match);
                $amount    = preg_match('R(.*)paid',$message->getHTMLBody());
                $user      = User::where('phone_number', $reference)->first();
                Wallet::where('user_id', $user->uudi)->update(['balance' => $amount]);
            }
        }

        return true;
    }

    protected function getClientManager()
    {
        return new ClientManager([
            'options' => [
                'delimiter'   => '/',
                'fetch'       => \Webklex\PHPIMAP\IMAP::FT_PEEK,
                'sequence'    => \Webklex\PHPIMAP\IMAP::ST_MSGN,
                'fetch_body'  => true,
                'fetch_flags' => true,
                'soft_fail'   => false,
                'message_key' => 'list',
                'fetch_order' => 'desc',
                'dispositions' => ['attachment', 'inline'],
                'common_folders' => [
                    "root" => "INBOX",
                    "junk" => "INBOX/Junk",
                    "draft" => "INBOX/Drafts",
                    "sent" => "INBOX/Sent",
                    "trash" => "INBOX/Trash",
                ],
                'decoder' => [
                    'message' => 'utf-8', // mimeheader
                    'attachment' => 'utf-8' // mimeheader
                ],
                'open' => [
                    // 'DISABLE_AUTHENTICATOR' => 'GSSAPI'
                ]
            ],
        ]);
    }
}
