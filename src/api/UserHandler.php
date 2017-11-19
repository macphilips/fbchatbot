<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/18/2017
 * Time: 1:46 PM
 */

namespace App\api;

use App\facade\FBUserFacade;
use App\service\DefaultFacadeService;
use App\service\FacadeService;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class UserHandler extends BaseRESTHandler
{
    /**
     * @var FacadeService
     */
    private $facadeService;
    /**
     * @var Logger
     */
    private $log;

    function __construct()
    {
        $this->facadeService = new DefaultFacadeService();
        $this->log = new Logger('general');
        $this->log->pushHandler(new StreamHandler('debug.log'));
    }

    function getUsers()
    {
        $users = $this->facadeService->getUsers();
        $statusCode = 200;

        $userArray = array();
        /** @var FBUserFacade $user */
        foreach ($users as $user) {
            $userArray[] = $user->toJSON();
        }
        $response = json_encode($userArray);

        $this->setHttpHeaders('application/json; charset=utf-8', $statusCode);
        //$this->setHttpHeaders('text/plain', $statusCode);

        $this->log->debug("UserHandler => ", array($response));
        echo $response;

    }

    function getUser($userID)
    {
        $user = $this->facadeService->getUser($userID);
        $statusCode = 200;
        $response = json_encode($user->toJSON());
        $this->setHttpHeaders('application/json', $statusCode);
        echo $response;
    }
}