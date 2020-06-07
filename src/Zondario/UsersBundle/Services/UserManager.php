<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 07-Jun-20
 * Time: 8:31 PM
 */

namespace Zondario\UsersBundle\Services;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zondario\UsersBundle\Entity\User;
use Zondario\UsersBundle\Exceptions\MethodNotCallableException;
use Zondario\UsersBundle\Exceptions\UserNotValidException;
use Zondario\UsersBundle\Interfaces\UserManagerInterface;
use Zondario\UsersBundle\Repository\UserRepository;

class UserManager implements UserManagerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * UserManager constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @return array
     */
    public function getAllUsers()
    {
        return $this->userRepository->findAll();
    }

    /**
     * @inheritdoc
     * @param $id
     * @return bool
     */
    public function deleteUserById($id)
    {
        try {
            $this->userRepository->deleteById($id);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @inheritdoc
     * @param User $user
     * @return bool
     */
    public function createUser(User $user)
    {
        $user->setCreatedAt(new \DateTime());
        $this->validateUser($user);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return true;
    }

    /**
     * @inheritdoc
     * @param array $criteria
     * @return User
     */
    public function getUser(array $criteria)
    {
        /**
         * @var $user User
         */
        $user = $this->userRepository->findOneBy($criteria);
        return $user;
    }

    /**
     * Get user by criteria
     * @param $newValues array
     * @param user User
     * @return User
     */
    public function editUser(array $newValues, User $user)
    {
        foreach ($newValues as $prop => $value) {
            $setter = 'set'. ucfirst($prop);
            if (!is_callable([$user, $setter])) {
                throw new MethodNotCallableException("{$setter} does not exist");
            }
            call_user_func_array([$user, $setter], [$value]);
        }
        $this->validateUser($user);
        $this->entityManager->flush();
        return $user;
    }

    private function validateUser($user)
    {
        $validationResult = $this->validator->validate($user);
        if (count($validationResult)) {
            $message = "";
            foreach ($validationResult as $constraint) {
                $message .= $constraint->getPropertyPath() . ":" . $constraint->getMessage() . ';';
            }
            throw new UserNotValidException($message);
        }
    }
}