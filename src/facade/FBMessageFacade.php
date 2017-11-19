<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/18/2017
 * Time: 12:44 PM
 */

namespace App\facade;


class FBMessageFacade
{
    private $message, $sender_id, $status, $time;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->sender_id;
    }

    /**
     * @param mixed $sender_id
     */
    public function setSenderId($sender_id)
    {
        $this->sender_id = $sender_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTime(): float
    {
        return $this->time;
    }


    /**
     * @param $time float
     */
    public function setTime($time)
    {
        $this->time = $time;
    }


    public function toJsonString()
    {
        return (array(
            'message' => $this->getMessage(),
            'time' =>  ($this->getTime()),
            'status' => $this->getStatus(),
            'sender_id' => $this->getSenderId(),
        ));

    }
}