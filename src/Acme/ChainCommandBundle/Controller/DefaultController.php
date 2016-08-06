<?php

namespace Acme\ChainCommandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeChainCommandBundle:Default:index.html.twig', array('name' => $name));
    }
}
