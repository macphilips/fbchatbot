<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/19/2017
 * Time: 12:18 AM
 */

namespace App\service;


use App\model\FBUser;
use Dotenv\Dotenv;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class FacebookGraphHelper
{


    /**
     * @param $id string
     * @return FBUser
     */
    public static function getUsersProfile($id)
    {        //$id = "4";
        $dotenv = new Dotenv(dirname(__FILE__, 3));
        $dotenv->load();
        $config = include(dirname(__FILE__, 2).'/include/config.php');
        $app_secret = $config["app_secret"];
        $app_id = $config["app_id"];
        $access_token = $config["access_token"];

        $fb = new Facebook([
            'app_id' => "$app_id",
            'app_secret' => "$app_secret",
            'default_graph_version' => 'v2.10',
            //'default_access_token' => '{access-token}', // optional
        ]);

        try {
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

        $user = new FBUser();
        $user->setUserID($id);
        $first_name = $graphNode->getField("first_name");
        $last_name = $graphNode->getField('last_name');
        $profile_pic = $graphNode->getField('profile_pic');
        $gender = $graphNode->getField('gender');
        $name = $graphNode->getField("name");

        if (isset($first_name)) {
            $user->setFirstName($first_name);
            $user->setLastName($last_name);
        } elseif (isset($name)) {
            $keys = preg_split('[\s]', $name);
            if (count($keys) == 2) {
                $user->setFirstName($keys[0]);
                $user->setLastName($keys[1]);
            } else {
                $user->setFirstName($name);
                $user->setLastName(' ');
            }
        } else {
            $user->setFirstName('Stranger');
            $user->setLastName(' ');
        }
        if (isset($profile_pic)) {
            $user->setProfile($profile_pic);
        } else {
            $user->setProfile('point to a default profile pix');
        }
        if (isset($gender)) {
            $user->setGender($gender);
        } else {
            $user->setGender('NA');
        }

        return $user;
    }
}