<?php

namespace Acme\CurrencyBundle\Form\Handler;

use Acme\CurrencyBundle\Model\CurrencyModel;
use Doctrine\Bundle\DoctrineBundle\Registry;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class CurrencyHandler
{
    /** @var FormFactory */
    protected $FormFactory;

    /** @var Registry */
    protected $doctrine;

    /**
     * @param FormFactory $FormFactory
     * @param Registry $doctrine
     */
    public function __construct(FormFactory $FormFactory, Registry $doctrine)
    {
        $this->FormFactory = $FormFactory;
        $this->doctrine = $doctrine;
    }

    /**
     * @param Request $request
     * @return bool|Form|FormInterface
     */
    public function process (Request $request)
    {
        $form = $this->FormFactory->create('currency_type', new CurrencyModel());
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $model = $form->getData();

                return true;
            }
        }

        return $form;
    }
}