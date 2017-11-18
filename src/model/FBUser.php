<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/17/2017
 * Time: 7:11 PM
 */

namespace App\model;


class FBUser
{
    private $userID,
        $profile,
        $gender,
        $first_name,
        $last_name;

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        $str = '';
        $str .= '[' . '<br/>';
        $str .= 'userID => ' . $this->userID . '<br/>';
        $str .= 'profile_pic => ' . $this->profile . '<br/>';
        $str .= 'first_name => ' . $this->first_name . '<br/>';
        $str .= 'last_name => ' . $this->last_name . '<br/>';
        $str .= ']<br/>';
        return $str;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }


    function __construct()
    {
    }

}