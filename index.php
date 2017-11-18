<?php

require_once __DIR__ . '/vendor/autoload.php';
use App\dao\DatabaseHelper;
use App\model\FBMessage;
use App\service\ChatbotHelper;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();
$database = new DatabaseHelper();

// Facebook webhook verification
$chatbotHelper->verifyWebhook($_REQUEST);

// Get the fb users data
$input = json_decode(file_get_contents('php://input'), true);

$log = new Logger('general');
$log->pushHandler(new StreamHandler('debug.log'));

$senderId = $chatbotHelper->getSenderId($input);

if ($senderId && $chatbotHelper->hasNewMessageReceipt($input)) {
    $log->debug('new message', array($input));
    $user = $database->userExists($senderId);
    if (!$user) {
        $user = $chatbotHelper->getUsersProfile($senderId);
        $database->saveUser($user);
    }
    $message = $chatbotHelper->getMessage($input);
    $message->setStatus('received');
    $database->saveMessage($message);

    $replyMessage = new FBMessage();
    $msg = $chatbotHelper->getAnswer($message->getMessage(), $user->getFirstName());
    $replyMessage->setMessage($msg);
    $replyMessage->setSenderID($senderId);
    $replyMessage->setStatus('sent');
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
    $log->debug('delivery receipt', array($input));
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
