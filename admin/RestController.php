<?php


require_once($_SERVER['DOCUMENT_ROOT'] . '/chatbot' . '/vendor/autoload.php');

use App\api\MessageHandler;
use App\api\RedirectHelper;
use App\api\UserHandler;

$url = "";
if (isset($_GET["url"]))
    $url = $_GET["url"];
/*
controls the RESTful services
URL mapping
*/
switch ($url) {
    case "users":
        // to handle REST Url /users/
        $users = new UserHandler();
        $users->getUsers();
        break;
    case "user":
        // to handle REST Url /user/<id>/
        $id = $_GET["id"];
        $users = new UserHandler();
        $users->getUser($id);
        break;

    case "messages" :
        // to handle REST Url /users/<id>/messages;
        $id = $_GET["id"];
        $msgHandler = new MessageHandler();
        $msgHandler->getMessageHistory($id);
        break;
    default:
        RedirectHelper::redirect('chatbot/home');
}


?>
