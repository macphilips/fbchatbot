<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/17/2017
 * Time: 6:23 PM
 */

namespace App\dao;


use App\model\FBMessage;
use App\model\FBUser;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use PDOException;

class DatabaseHelper
{

    /**
     * @var $conn PDO
     */
    protected $conn;
    /**
     * @var $log Logger
     */
    private $log;

    public function openConnection()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //    $this->log->error("openConnection", array($e->getMessage()));
            echo 'ERROR: ' . $e->getMessage();
        }

    }

    /**
     * @param $user FBUser
     */
    public function saveUser($user)
    {
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO users (first_name, last_name, profile_pic,gender,id) VALUES (:first_name, :last_name, :profile_pic, :gender,:id)");

        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $profile = $user->getProfile();
        $gender = $user->getGender();
        $userID = $user->getUserID();

        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':profile_pic', $profile);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':id', $userID);


        $stmt->execute();
        //$this->log->debug("saveUser", array($execute));
    }

    /**
     * @param $msg FBMessage
     */
    public function saveMessage($msg)
    {
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO message_history (sender_id, status, message,time,mid) VALUES (:sender_id, :direction, :message, :time,:mid)");

        $stmt->bindParam(':sender_id', $senderID);
        $stmt->bindParam(':direction', $direction);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':mid', $mid);

        $senderID = $msg->getSenderID();
        $direction = $msg->getStatus();
        $time = $msg->getTime();
        $message = $msg->getMessage();
        $mid = $msg->getMid();

        $stmt->execute();
        // $this->log->debug("saveMessage", array($execute));
    }

    /**
     * @param $id string
     * @return bool|FBUser
     */
    public function userExists($id)
    {
        $stmt = $this->conn->prepare('SELECT COUNT(*) AS result FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if ($result[0]['result'] == 0) {
            return false;
        } else {
            return $this->getUser($id);
        }
    }

    /**
     * @param $id
     * @return FBUser
     */
    public function getUser($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        $var = $result[0];

        $user = new FBUser();
        $this->log->debug('getUser => ', array($result));
        $user->setUserID($var['id']);
        $user->setLastName($var['last_name']);
        $user->setFirstName($var['first_name']);
        $user->setGender($var['gender']);
        $user->setProfile($var['profile_pic']);

        return $user;

    }

    /**
     * @return array|FBUser
     */
    public function getUsers()
    {
        $stmt = $this->conn->prepare('SELECT id,first_name,profile_pic,last_name,gender FROM users');
        //$stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        $users = array();
        foreach ($result as $var) {
            $user = new FBUser();
            $user->setUserID($var['id']);
            $user->setLastName($var['last_name']);
            $user->setFirstName($var['first_name']);
            $user->setGender($var['gender']);
            $user->setProfile($var['profile_pic']);
            $users[] = $user;
            //  $this->log->debug("getting List of Users => ", array($var));
        }
        return $users;
    }

    /**
     * @param $message FBMessage
     */
    public function updateMessage($message)
    {
        $stmt = $this->conn->prepare('UPDATE message_history SET status=:s, time = :t WHERE mid = :id');

        $stmt->bindParam(':s', $status);
        $stmt->bindParam(':t', $time);
        $stmt->bindParam(':id', $mid);

        $status = $message->getStatus();
        $time = $message->getTime();
        $mid = $message->getMid();

        $stmt->execute();
    }

    /**
     * @param $mid
     * @return FBMessage
     */
    public function getMessage($mid)
    {
        $stmt = $this->conn->prepare('SELECT * FROM message_history WHERE mid = :id');
        $stmt->bindParam(':id', $mid, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $value = $stmt->fetchAll()[0];
        $this->log->debug('getMessage', array($mid, $value));
        $msg = new FBMessage();
        $msg->setStatus($value['status']);
        $msg->setMid($value['mid']);
        $msg->setMessage($value['message']);
        $msg->setTime($value['time']);
        $msg->setSenderID('sender_id');

        return $msg;
    }

    /**
     * @param $id
     * @return array|FBMessage
     */
    public function getMessageHistory($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM message_history WHERE sender_id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        $messages = array();
        foreach ($result as $value) {
            $msg = new FBMessage();
            $msg->setStatus($value['status']);
            $msg->setMid($value['mid']);
            $msg->setMessage($value['message']);
            $msg->setTime($value['time']);
            $msg->setSenderID('sender_id');
            $messages[] = $msg;
        }
        return $messages;
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * @return string
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    function __construct()
    {
        $dotenv = new Dotenv(dirname(__FILE__, 3));
        $dotenv->load();
        $this->dsn = getenv('DSN');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->log = new Logger('general');
        $this->log->pushHandler(new StreamHandler('debug.log'));
        $this->openConnection();

    }


}