<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 07-Jun-20
 * Time: 9:00 PM
 */

namespace Zondario\CoreBundle\Factory;


use Doctrine\ORM\EntityManagerInterface;

class EntityRepositoryFactory
{
    public function getEntityRepository(EntityManagerInterface $entityManager, $class)
    {
        return $entityManager->getRepository($class);
    }
}