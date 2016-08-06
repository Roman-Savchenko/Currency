<?php

namespace Acme\BarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeBarBundle:Default:index.html.twig', array('name' => $name));
    }
}
