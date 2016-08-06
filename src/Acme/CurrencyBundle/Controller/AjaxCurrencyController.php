<?php

namespace Acme\CurrencyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\CurrencyBundle\Manager\CurrencyManager;

class AjaxCurrencyController extends Controller
{
    /**
     * @Route("/ajax_form", name="ajax_form")
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {

        $currencyId = $request->request->get('currencyId');
        $year = $request->request->get('year');
        $month = $request->request->get('month');
        $day = $request->request->get('day');
        $date = $year . '-' . $month . '-' . $day;

        $result = $this->container->get('ajax_manager')->getResponse($currencyId, $date);

        $response = [
            'status' => true,
            'message' => $result
        ];
        return new JsonResponse($response);
    }
}