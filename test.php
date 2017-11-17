<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/17/2017
 * Time: 8:26 AM
 */

require_once __DIR__ . '/vendor/autoload.php'; // change path as needed
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

/* Connect to a MySQL database using driver invocation
$dsn = 'mysql:dbname=fbchatbot;host=127.0.0.1';
$user = 'macphilips';
$password = 'oreoluwa';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

*/

$id = "4";
$app_secret = getenv('APP_SECRET');
$app_id = getenv('APP_ID');
echo $app_id;
$access_token = getenv('PAGE_ACCESS_TOKEN');

$fb = new Facebook([
    'app_id' => "$app_id",
    'app_secret' => "$app_secret",
    'default_graph_version' => 'v2.10',
    //'default_access_token' => '{access-token}', // optional
]);
$helper = $fb->getPageTabHelper();

try {
    // Get the \Facebook\GraphNodes\GraphUser object for the current user.
    // If you provided a 'default_access_token', the '{access-token}' is optional.
    $response = $fb->get('/me', "$access_token");
} catch (FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$me = $response->getGraphUser();
printf("%s\n", $me);

try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get(
        "/$id",
        "$access_token"
    );
} catch (FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
$graphNode = $response->getGraphNode();
/* handle the result */
echo 'Name of User ID =>' . $graphNode;