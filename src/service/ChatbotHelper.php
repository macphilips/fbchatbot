<?php

namespace App\service;


use App\model\FBMessage;
use App\model\FBUser;
use Dotenv\Dotenv;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ChatbotHelper
{

    protected $chatbotAI;
    protected $facebookSend;
    protected $log;
    private $accessToken;
    public $config;

    public function __construct()
    {
        $dotenv = new Dotenv(dirname(__FILE__, 3));
        $dotenv->load();
        $this->accessToken = getenv('PAGE_ACCESS_TOKEN');
        $this->config = include(dirname(__FILE__, 2) . '/include/config.php');
        $this->governors = include(dirname(__FILE__, 2) . '/include/governors.php');
        $this->chatbotAI = new ChatbotAI($this->config, $this->governors);
        $this->facebookSend = new FacebookSend();
        $this->log = new Logger('general');
        $this->log->pushHandler(new StreamHandler('debug.log'));
    }

    /**
     * Get the sender id of the message
     * @param $input
     * @return mixed
     */
    public function getSenderId($input)
    {
        $id = $input['entry'][0]['messaging'][0]['sender']['id'];
        return "$id";
    }

    /**
     * Get the user's message from input
     * @param $input
     * @return FBMessage
     */
    public function getMessage($input)
    {
        $message = new FBMessage();
        $messageData = $input['entry'][0]['messaging'][0];

        $message->setMessage($messageData['message']['text']);
        $message->setMid($messageData['message']['mid']);
        $message->setSenderID($messageData['sender']['id']);
        $message->setTime($messageData['timestamp']);
        $this->log->debug('getMessage => ', array($messageData['timestamp']));
        return $message;
    }

    /**
     * Check if the callback is a user message
     * @param $input
     * @return bool
     */
    public function hasNewMessageReceipt($input)
    {
        return isset($input['entry'][0]['messaging'][0]['message']['text']) && !isset
            ($input['entry'][0]['messaging'][0]['message']['is_echo']);
    }

    /**
     * Check if the callback is a user message
     * @param $input
     * @return bool
     */
    public function hasReadMessageReceipt($input)
    {
        return isset($input['entry'][0]['messaging'][0]['read']);
    }

    /**
     * Check if the callback is a user message
     * @param $input
     * @return bool
     */
    public function hasDeliveryMessageReceipt($input)
    {
        return isset($input['entry'][0]['messaging'][0]['delivery']['mids']);
    }

    /**
     * Get the answer to a given user's message
     * @param string $message
     * @param string $name
     * @return string
     * @internal param null $api
     */
    public function getAnswer($message, $name = '')
    {
        return $this->chatbotAI->getAnswer($message, $name);
    }

    /**
     * Send a reply back to Facebook chat
     * @param $senderId
     * @param $replyMessage
     * @return mixed
     */
    public function send($senderId, string $replyMessage)
    {
        $result = $this->facebookSend->send($this->accessToken, $senderId, $replyMessage);
        return $result;
    }

    /**
     * Verify Facebook webhook
     * This is only needed when you setup or change the webhook
     * @param $request
     * @return mixed
     */
    public function verifyWebhook($request)
    {
        if (!isset($request['hub_challenge'])) {
            return false;
        };

        $hubVerifyToken = null;
        $hubVerifyToken = $request['hub_verify_token'];
        $hubChallenge = $request['hub_challenge'];

        if (isset($hubChallenge) && $hubVerifyToken == $this->config['webhook_verify_token']) {
            echo $hubChallenge;
        }
        return '';

    }

    /**
     * @param $input
     * @return array
     */
    public function getDeliveryReceipt($input)
    {
        $receipt = array();
        $mids = $input['entry'][0]['messaging'][0]['delivery']['mids'] [0];
        $watermark = $input['entry'][0]['messaging'][0]['delivery']['watermark'];
        $time = $input['entry'][0]['messaging'][0]['timestamp'];
        $receipt['time'] = $time;
        $receipt['watermark'] = $watermark;
        $receipt['mid'] = $mids;
        return $receipt;
    }

    /**
     * @param $input
     * @return array
     */
    public function getReadReceipt($input)
    {
        $receipt = array();
        $watermark = $input['entry'][0]['messaging'][0]['read']['watermark'];
        $time = $input['entry'][0]['messaging'][0]['timestamp'];
        $receipt['time'] = $time;
        $receipt['watermark'] = $watermark;
        return $receipt;
    }


}