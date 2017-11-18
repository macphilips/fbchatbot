<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/17/2017
 * Time: 6:06 PM
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
use App\DatabaseHelper;

$database = new DatabaseHelper();
$users = $database->getUsers();
foreach ($users as $user)
    echo json_encode($user->getJsonStr()).'<br/>';



