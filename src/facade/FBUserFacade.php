<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/18/2017
 * Time: 12:44 PM
 */

namespace App\facade;


class FBUserFacade
{
    private $name, $profile, $id, $last_msg;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLastMsg()
    {
        return $this->last_msg;
    }

    /**
     * @param mixed $last_msg
     */
    public function setLastMsg($last_msg)
    {
        $this->last_msg = $last_msg;
    }

    public function toJSON()
    {
        return (array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'profile' => $this->getProfile(),
            'last_message' => $this->getLastMsg()
        ));
    }
}