<?php

namespace Zondario\UsersBundle\Models;


/**
 * Class DeleteUser
 * @package Zondario\UsersBundle\Models
 */
class DeleteUser
{
    /**
     * @var $users
     */
    private $success;

    public function getSuccess()
    {
        return $this->success;
    }

    public function setSuccess($success)
    {
        $this->success = $success;
    }
}