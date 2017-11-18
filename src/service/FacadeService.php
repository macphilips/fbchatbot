<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/18/2017
 * Time: 1:34 PM
 */

namespace App\service;

use App\facade\FBUserFacade;

interface FacadeService
{
    public function getUser($userID): FBUserFacade;

    public function getUsers(): array;

    public function getMessageHistory($userID): array;
}