<?php

namespace App\service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class FacebookSend
{

    protected $apiUrl = 'https://graph.facebook.com/v2.6/me/messages';
    protected $log;
    protected $facebookPrepareData;

    public function __construct()
    {
        $this->log = new Logger('general');
        $this->log->pushHandler(new StreamHandler('debug.log'));
        $this->facebookPrepareData = new FacebookPrepareData();
    }

    /**
     * @param string $accessToken
     * @param string $senderId
     * @param string $replyMessage
     * @internal param string $jsonDataEncoded
     * @return mixed
     */
    public function send(string $accessToken, string $senderId, string $replyMessage)
    {

        $jsonDataEncoded = $this->facebookPrepareData->prepare($senderId, $replyMessage);

        $url = $this->apiUrl . '?access_token=' . $accessToken;
        $ch = curl_init($url);

        // Tell cURL to send POST request.
        curl_setopt($ch, CURLOPT_POST, 1);

        // Attach JSON string to post fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Set the content type
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute
       $result = curl_exec($ch);


        if (curl_error($ch)) {
            $this->log->warning('Send Facebook Curl error: ' . curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }

}
