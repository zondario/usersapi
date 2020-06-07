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
 * Class ListUsers
 * @package Zondario\UsersBundle\Models
 */
class ListUsers
{
    /**
     * @Serializer\Groups({"users_list_response"})
     * @var $users
     */
    private $users;

    public function getUsers()
    {
        return $this->users;
    }

    public function setUsers($users)
    {
        $this->users = $users;
    }
}