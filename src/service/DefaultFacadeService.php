<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/18/2017
 * Time: 1:35 PM
 */

namespace App\service;


use App\dao\DatabaseHelper;
use App\facade\FBMessageFacade;
use App\facade\FBUserFacade;
use App\model\FBMessage;
use App\model\FBUser;

class DefaultFacadeService implements FacadeService
{
    private $database;

    function __construct()
    {
        $this->database = new   DatabaseHelper();
    }

    public function getMessageHistory($userID): array
    {
        // TODO: Implement getMessageHistory() method.
        $msgFacades = array();
        $messages = $this->database->getMessageHistory($userID);
        /** @var FBMessage $message */
        foreach ($messages as $message) {
            $msgFacade = new FBMessageFacade();

            $sender_id = $message->getSenderID();
            $msgFacade->setMessage($message->getMessage());
            $msgFacade->setStatus($message->getStatus());
            $msgFacade->setSenderId($userID);
            $msgFacade->setTime($message->getTime());
            $msgFacades[] = $msgFacade;
        }
        return $msgFacades;
    }

    public function getUser($userID): FBUserFacade
    {
        // TODO: Implement getUser() method.

        $fbUser = $this->database->getUser($userID);
        $user_facade = new FBUserFacade();
        $user_facade->setName($fbUser->getFirstName() . ' ' . $fbUser->getLastName());
        $user_facade->setProfile($fbUser->getProfile());
        $user_facade->setId($fbUser->getUserID());
        $messageHistory = $this->getMessageHistory($userID);
        /** @var FBMessageFacade $lst_mgs */
        $lst_mgs = $messageHistory[count($messageHistory) - 1];
        $user_facade->setLastMsg($lst_mgs->getMessage());
        return $user_facade;
    }

    public function getUsers(): array
    {
        $user_facades = array();
        // TODO: Implement getUsers() method.
        /** @var FBUser $fbUser */
        foreach ($this->database->getUsers() as $fbUser) {
            $user_facade = new FBUserFacade();
            $user_facade->setName($fbUser->getFirstName() . ' ' . $fbUser->getLastName());
            $user_facade->setProfile($fbUser->getProfile());
            $user_facade->setId($fbUser->getUserID());
            $messageHistory = $this->getMessageHistory($fbUser->getUserID());
            /** @var FBMessageFacade $lst_mgs */
            $lst_mgs = $messageHistory[count($messageHistory) - 1];
            $user_facade->setLastMsg($lst_mgs->getMessage());
            $user_facades[] = $user_facade;
        }
        return $user_facades;
    }
}