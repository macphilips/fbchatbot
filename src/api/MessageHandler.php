<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/18/2017
 * Time: 1:46 PM
 */

namespace App\api;


use App\facade\FBMessageFacade;
use App\service\DefaultFacadeService;
use App\service\FacadeService;

class MessageHandler extends BaseRESTHandler
{
    /**
     * @var FacadeService
     */
    private $facadeService;

    function __construct()
    {
        $this->facadeService = new DefaultFacadeService();
    }

    function getMessageHistory($userID)
    {
        $messagesHistory = $this->facadeService->getMessageHistory($userID);

        $statusCode = 200;

        $messageArray = array();
        foreach ($messagesHistory as $item) {
            /** @var FBMessageFacade $item */
            $messageArray[] = $item->toJsonString();
        }
        $user = $this->facadeService->getUser($userID);
        $response = json_encode(array('name' => $user->getName(), 'profile_pic' => $user->getProfile(),
            'messages' => $messageArray));
        $this->setHttpHeaders('application/json; charset=UTF-8', $statusCode);
        echo $response;
    }
}