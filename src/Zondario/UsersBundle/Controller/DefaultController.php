<?php

namespace Zondario\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ZondarioUsers/Default/index.html.twig');
    }
}
