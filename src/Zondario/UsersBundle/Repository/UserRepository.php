<?php

namespace Zondario\UsersBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

    public function deleteById($id)
    {
        $this->createQueryBuilder('u')
        ->delete($this->getEntityName(), 'u')
        ->where('u.id = :id')
        ->setParameter("id", $id)
        ->getQuery()
        ->execute();
    }
}
