<?php

namespace Zondario\CoreBundle\Output;

use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Zondario\Core\Http\SupportedContentTypes;
use Zondario\CoreBundle\Factory\SerializerFactory;
use Zondario\CoreBundle\Interfaces\Output\HandlerInterface;

class Handler implements HandlerInterface
{
    private $outputContentType;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var RequestStack
     */
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->request = $requestStack->getMasterRequest();
    }

    public function createResponse($model, $serializerContext)
    {
        $serializer = SerializerFactory::getDefaultSerializer();
        $context = SerializationContext::create()->setGroups(
            is_array($serializerContext ) ? $serializerContext : [$serializerContext]
        );
        $contentType = $this->outputContentType;
        return new Response($serializer->serialize($model, $contentType, $serializerContext ? $context : null));
    }

    public function validateOutputMediaType()
    {
        $outputContentType = $this->decideOutputContentType();
        if (!$outputContentType) {
            throw new NotAcceptableHttpException();
        }
        $this->outputContentType = $outputContentType;
    }

    private function decideOutputContentType()
    {
        $acceptable = $this->request->getAcceptableContentTypes();
        foreach ($acceptable as $type) {
            if ($type === '*/*') {
                return 'json';
            }
            if (SupportedContentTypes::isTypeSupported($type)) {
                return SupportedContentTypes::getSerializerRepresentationOfContentType($type);
            }
        }
        return null;
    }
}