<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/17/2017
 * Time: 6:06 PM
 */

use App\dao\DatabaseHelper;

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$database = new DatabaseHelper();
$users = $database->getUser('2178859302139932');
echo $users;



