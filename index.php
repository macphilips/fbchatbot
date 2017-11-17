<?php

require_once __DIR__ . '/vendor/autoload.php';
use App\ChatbotHelper;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$log = new Logger('general');
$log->pushHandler(new StreamHandler('debug.log'));
// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();

// Facebook webhook verification
$chatbotHelper->verifyWebhook($_REQUEST);

// Get the fb users data
$input = json_decode(file_get_contents('php://input'), true);

//$log->debug("input", $input);
$senderId = $chatbotHelper->getSenderId($input);
$log->debug("Sender ID", array($senderId));
if ($senderId && $chatbotHelper->isMessage($input)) {
    $log->debug("Has Message", array($chatbotHelper->isMessage($input)));
    // Get the user's message
    $message = $chatbotHelper->getMessage($input);

    // Example 1: Get a static message back
    $replyMessage = $chatbotHelper->getAnswer($message);

    // Example 2: Get foreign exchange rates
    // $replyMessage = $chatbotHelper->getAnswer($message, 'rates');


    $chatbotHelper->send($senderId, $replyMessage);

}
