<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 07-Jun-20
 * Time: 8:34 PM
 */

namespace Zondario\UsersBundle\Interfaces;


use Zondario\UsersBundle\Entity\User;

interface UserManagerInterface
{
    /**
     * Returns all users in the database
     *
     * @return User[]
     */
    public function getAllUsers();

    /**
     * Deletes user by specified id
     * @param $id
     * @return bool
     */
    public function deleteUserById($id);

    /**
     * Creates user
     * @param $user User
     * @return bool
     */
    public function createUser(User $user);

    /**
     * Get user by criteria
     * @param $criteria
     * @return User
     */
    public function getUser(array $criteria);

    /**
     * Get user by criteria
     * @param $newValues array
     * @param user User
     * @return User
     */
    public function editUser(array $newValues, User $user);
}