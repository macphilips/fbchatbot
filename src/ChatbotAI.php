<?php

namespace App;


use ApiAi\Client;
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
        $this->log->debug();
    }

    /**
     * Get the answer to the user's message
     * @param $message
     * @return string
     */
    public function getAnswer(string $message)
    {

        if (preg_match('[hi|hey|hello]', strtolower($message))) {
            return 'Hi, nice to meet you!';
        } elseif (preg_match('[What is today[\'s] date|What day is it|date|What day is it?]', strtolower($message))) {
            return "Today's date is " . date('F jS, Y');
        } elseif (preg_match('[time|What is the time|what says the time]', strtolower($message))) {
            return "The time is " . date('h:i A');
        } elseif (preg_match('[who is the governor of ]', strtolower($message))) {
            $keywords = preg_split("/[\s,]+/", strtolower($message));
            foreach ($this->governors as $key => $value) {
                foreach ($keywords as $v) {
                    if (strtolower($v) === strtolower($key)) {
                        return $value;
                    }

                }
            }
            return "I don't know, ask Google";
        } else {
            return 'Define your own logic to reply to this message: ' . $message;
        }
    }

}