<?php

/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/17/2017
 * Time: 10:29 PM
 */

namespace App;

class FBMessage
{
    private $senderID;
    private $status;
    private $message;
    private $mid;
    private $time;

    /**
     * @return string
     */
    public function getMid(): string
    {
        return $this->mid;
    }

    /**
     * @param string $mid
     */
    public function setMid(string $mid)
    {
        $this->mid = $mid;
    }

    /**
     * @return int
     */
    public function getWatermark(): int
    {
        return $this->watermark;
    }

    /**
     * @param int $watermark
     */
    public function setWatermark(int $watermark)
    {
        $this->watermark = $watermark;
    }

    function __construct()
    {
        $this->senderID = '';
        $this->status = '';
        $this->message = ' ';
        $this->time = 0;
        $this->mid = '';
        $this->watermark = 0;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $direction
     */
    public function setStatus(string $direction)
    {
        $this->status = $direction;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getSenderID(): string
    {
        return $this->senderID;
    }

    /**
     * @param string $senderID
     */
    public function setSenderID(string $senderID)
    {
        $this->senderID = $senderID;
    }

    /**
     * @return int
     */
    public function getTime(): float
    {
        return $this->time;
    }

    /**
     * @param float $time
     */
    public function setTime(float $time)
    {
        $this->time = $time;

    }


}