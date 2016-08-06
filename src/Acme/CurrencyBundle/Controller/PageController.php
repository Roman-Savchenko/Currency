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

class PageController extends Controller
{
    /**
     * @Route("/main", name="main_currency_page")
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->container->get('currency_handler')->process($request);

        if ($form instanceof FormInterface) {
            return $this->render("AcmeCurrencyBundle:Default:index.html.twig", array(
                'form' => $form->createView(),
            ));
        }

        return new Response("<h1>ok</h1>");
    }
}