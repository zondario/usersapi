<?php

namespace Zondario\UsersBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Zondario\CoreBundle\Factory\SerializerFactory;
use Zondario\CoreBundle\Interfaces\Output\HandlerInterface;
use Zondario\UsersBundle\Exceptions\MethodNotCallableException;
use Zondario\UsersBundle\Exceptions\UserNotValidException;
use Zondario\UsersBundle\Interfaces\UserBuilderInterface;
use Zondario\UsersBundle\Interfaces\UserManagerInterface;
use Zondario\UsersBundle\Models\CreateUser;
use Zondario\UsersBundle\Models\DeleteUser;
use Zondario\UsersBundle\Models\EditUser;
use Zondario\UsersBundle\Models\ListUsers;

class UserManagementController extends Controller
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;
    /**
     * @var HandlerInterface
     */
    private $outputHandler;
    /**
     * @var UserBuilderInterface
     */
    private $userBuilder;

    public function __construct(
        UserManagerInterface $userManager,
        HandlerInterface $outputHandler,
        UserBuilderInterface $userBuilder
    ) {
        $this->userManager = $userManager;
        $this->outputHandler = $outputHandler;
        $this->userBuilder = $userBuilder;
    }

    /**
     * @Route("/list", name="users_list")
     */
    public function listUsers()
    {
        $this->outputHandler->validateOutputMediaType();
        $users = $this->userManager->getAllUsers();
        $model = new ListUsers();
        $model->setUsers($users);
        return $this->outputHandler->createResponse($model, 'users_list_response');
    }

    /**
     * @Route("/create", name="user_create", methods={"POST"})
     */
    public function createUser()
    {
        $this->outputHandler->validateOutputMediaType();
        $user = $this->userBuilder->createFromPost();
        try {
            $this->userManager->createUser($user);
        } catch (UserNotValidException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }
        $model = new CreateUser();
        $model->setUser($user);
        return $this->outputHandler->createResponse($model, 'user_create_response');
    }

    /**
     * @Route("/delete/{id}", name="user_delete", methods={"DELETE"})
     */
    public function deleteUser(int $id)
    {
        $this->outputHandler->validateOutputMediaType();
        $success = $this->userManager->deleteUserById($id);
        $model = new DeleteUser();
        $model->setSuccess($success);
        return $this->outputHandler->createResponse($model, null);
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"PATCH"})
     */
    public function editUser(int $id )
    {
        $this->outputHandler->validateOutputMediaType();
        $body = $this->getRequestContentAsArray();
        $user = $this->userManager->getUser(['id' => $id]);
        if (!$user) {
            throw new NotFoundHttpException();
        }
        try {
            $user = $this->userManager->editUser($body, $user);
        } catch (MethodNotCallableException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }
        $model = new EditUser();
        $model->setUser($user);
        return $this->outputHandler->createResponse($model, 'user_edit_response');
    }

    private function getRequestContentAsArray()
    {
        return $this->userBuilder->deserializeUserModificationsFromRequestToArray();
    }
}