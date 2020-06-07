<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 07-Jun-20
 * Time: 11:32 PM
 */

namespace Zondario\UsersBundle\Interfaces;

interface UserBuilderInterface
{
    public function createFromPost();

    public function deserializeUserModificationsFromRequestToArray();
}