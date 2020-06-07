<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 07-Jun-20
 * Time: 11:29 PM
 */

namespace Zondario\UsersBundle\Services;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Zondario\Core\Http\SupportedContentTypes;
use Zondario\CoreBundle\Factory\SerializerFactory;
use Zondario\UsersBundle\Entity\User;
use Zondario\UsersBundle\Interfaces\UserBuilderInterface;

class UserBuilder implements UserBuilderInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->request = $requestStack->getMasterRequest();
    }

    public function createFromPost()
    {
        $post = $this->request->getContent();
        $contentType = $this->request->getContentType();
        if (!SupportedContentTypes::isTypeSupported($contentType)) {
            throw new UnsupportedMediaTypeHttpException();
        }
        $serializer = SerializerFactory::getDefaultSerializer();
        $user = $serializer->deserialize($post, User::class, $contentType);
        return $user;
    }

    public function deserializeUserModificationsFromRequestToArray()
    {
        $post = $this->request->getContent();
        $contentType = $this->request->getContentType();
        if (!SupportedContentTypes::isTypeSupported($contentType)) {
            throw new UnsupportedMediaTypeHttpException();
        }
        $serializer = SerializerFactory::getDefaultSerializer();
        $user = $serializer->deserialize($post, 'array', $contentType);
        return $user;
    }
}