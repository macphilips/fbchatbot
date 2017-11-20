<?php

require_once __DIR__ . '/vendor/autoload.php';
use App\dao\DatabaseHelper;
use App\model\FBMessage;
use App\service\ChatbotHelper;
use App\service\FacebookGraphHelper;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();
$database = new DatabaseHelper();

function saveFbPageName()
{
    $dotenv = new Dotenv(dirname(__FILE__, 3));
    $dotenv->load();
    $page = getenv('PAGE_NAME');
    if (!isset($page)){
      $page  = FacebookGraphHelper::getUsersProfile('me');
      putenv('PAGE_NAME='.$page);
    }
}

// Facebook webhook verification
$chatbotHelper->verifyWebhook($_REQUEST);

// Get the fb users data
$input = json_decode(file_get_contents('php://input'), true);

$log = new Logger('general');
$log->pushHandler(new StreamHandler('debug.log'));

$senderId = $chatbotHelper->getSenderId($input);

if ($senderId && $chatbotHelper->hasNewMessageReceipt($input)) {

    $message = $chatbotHelper->getMessage($input);
    $message->setStatus('received');

    $replyMessage = new FBMessage();
    $msg = $chatbotHelper->getAnswer($message->getMessage(),  $message->getSenderID());
    $replyMessage->setMessage($msg);
    $replyMessage->setSenderID($senderId);
    $replyMessage->setStatus('sent');


    $database->saveMessage($message);
    $send = $chatbotHelper->send($senderId, $msg);
    $response = json_decode($send);

    foreach ($response as $key => $k) {
        if ($key == 'message_id') {
            $replyMessage->setMid($k);
        }
    }

    $database->saveMessage($replyMessage);
}

if ($senderId && $chatbotHelper->hasDeliveryMessageReceipt($input)) {
    $receipt = $chatbotHelper->getDeliveryReceipt($input);
    $message = $database->getMessage($receipt['mid']);
    $message->setTime($receipt['time']);
    $message->setStatus("delivered");
    $database->updateMessage($message);
}
if ($senderId && $chatbotHelper->hasReadMessageReceipt($input)) {
    // $log->debug('read receipt', array($input));
    //TODO
    /* $receipt = $chatbotHelper->getReadReceipt($input);
     $message = $database->getMessage($receipt['mid']);
     $message->setTime($receipt['time']);
     $message->setStatus("delivered");
     $database->updateMessage($message);*/
}
