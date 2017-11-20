<?php

namespace App\service;


use App\dao\DatabaseHelper;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ChatbotAI
{

    protected $apiClient;
    protected $config;
    private $log;
    private $governors;

    /**
     * ChatbotAI constructor.
     * @param $config
     */
    public function __construct($config, $governors)
    {
        $this->governors = $governors;
        $this->config = $config;
        $this->log = new Logger('general');
        $this->log->pushHandler(new StreamHandler('debug.log'));
    }

    /**
     * Get the answer to the user's message
     * @param string $message
     * @param string $sendID
     * @return string
     */
    public function getAnswer(string $message, $sendID = '')
    {
        $db = new DatabaseHelper();
        $user = $db->userExists($sendID);
        $welcome = '';
        if (!$user) {
            $user = FacebookGraphHelper:: getUsersProfile($sendID);
            $db->saveUser($user);
            $welcome =  'Hi ' .  $user->getFirstName().'!  Nice to meet you ';
        }else{
            $welcome = 'Hi ' .  $user->getFirstName().'! Welcome Back';
        }

        if (preg_match('[hi|hey|hello]', strtolower($message))) {

            return $welcome;

        } elseif (preg_match('[What is today[\'s] date|What day is it|date|What day is it?]', strtolower($message))) {
            return "Today's date is " . date('F jS, Y');
        } elseif (preg_match('[time|What is the time|what says the time]', strtolower($message))) {
            return "The time is " . date('h:i A');
        } elseif (preg_match('[who is the governor of ]', strtolower($message))) {
            foreach ($this->governors as $key => $value) {
                $state = strtolower($key);
                if (preg_match("[$state]", strtolower($message))) {
                    return $value;
                }
            }
            return "I don't know, ask Google";
        } else {
            return 'Sorry I don\'t understand your question: \n\r' . $message;
        }
    }


}