<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 07-Jun-20
 * Time: 9:12 PM
 */

namespace Zondario\UsersBundle\Models;


use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Zondario\UsersBundle\Entity\User;

/**
 * Class EditUser
 * @package Zondario\UsersBundle\Models
 */
class EditUser
{
    /**
     * @Serializer\Groups({"user_edit_response"})
     * @var $users
     */
    private $user;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}