<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 07-Jun-20
 * Time: 10:50 PM
 */

namespace Zondario\CoreBundle\Interfaces\Output;


interface HandlerInterface
{
    public function createResponse($model, $serializerContext);
}