<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/17/2017
 * Time: 8:26 AM
 */

require_once __DIR__ . '/vendor/autoload.php';
use App\DatabaseHelper;

$db = new DatabaseHelper();
echo $db->getUsers()[0];