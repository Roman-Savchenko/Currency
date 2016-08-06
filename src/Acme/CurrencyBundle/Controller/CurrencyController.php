<?php

namespace Acme\CurrencyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\CurrencyBundle\Manager\CurrencyManager;

class CurrencyController extends Controller
{
    /**
     * @Route("/load", name="load_currency")
     *
     * @return Response
     */
    public function loadAction()
    {
        $content = simplexml_load_file('http://bank.gov.ua/NBUStatService/v1/statdirectory/exchange');
        $result = $this->container->get('acme_currency.currency_manager')->getData($content);
        if ($result === true) {
            return $this->redirectToRoute("main_currency_page");
        }
    }
}