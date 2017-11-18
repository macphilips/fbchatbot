<?php

namespace App;


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
        $dotenv = new Dotenv(dirname(__FILE__, 2));
        $dotenv->load();
        $this->accessToken = getenv('PAGE_ACCESS_TOKEN');
        $this->config = include('config.php');
        $this->governors = include('governors.php');
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
        $inputdata = $input['entry'][0]['messaging'][0];
        $message->setMessage($inputdata['message']['text']);
        $message->setMid($inputdata['message']['mid']);
        $message->setSenderID($inputdata['sender']['id']);
        $message->setTime($inputdata['timestamp']);
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

    }

    /**
     * @param $id string
     * @return FBUser
     */
    public function getUsersProfile($id)
    {        //$id = "4";
        $app_secret = $this->config["app_secret"];
        $app_id = $this->config["app_id"];
        $access_token = $this->config["access_token"];

        $fb = new Facebook([
            'app_id' => "$app_id",
            'app_secret' => "$app_secret",
            'default_graph_version' => 'v2.10',
            //'default_access_token' => '{access-token}', // optional
        ]);

        try {
            $response = $fb->get(
                "/$id",
                "$access_token"
            );
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();

        $user = new FBUser();
        $user->setUserID($id);
        $first_name = $graphNode->getField("first_name");
        $last_name = $graphNode->getField('last_name');
        $profile_pic = $graphNode->getField('profile_pic');
        $gender = $graphNode->getField('gender');
        $name = $graphNode->getField("name");

        if (isset($first_name)) {
            $user->setFirstName($first_name);
            $user->setLastName($last_name);
        } elseif (isset($name)) {
            $keys = preg_split('[\s]', $name);
            if (count($keys) == 2) {
                $user->setFirstName($keys[0]);
                $user->setLastName($keys[1]);
            } else {
                $user->setFirstName($name);
                $user->setLastName(' ');
            }
        } else {
            $user->setFirstName('Stranger');
            $user->setLastName(' ');
        }
        if (isset($profile_pic)) {
            $user->setProfile($profile_pic);
        } else {
            $user->setProfile('point to a default profile pix');
        }
        if (isset($gender)) {
            $user->setGender($gender);
        } else {
            $user->setGender('NA');
        }

        $this->log->debug("ChatbotHelper.getUserProfile => ", array($user));
        return $user;
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