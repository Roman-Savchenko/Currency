<?php

namespace Acme\CurrencyBundle\Manager;

use Acme\CurrencyBundle\Entity\Currency;
use Acme\CurrencyBundle\Entity\CurrencyDate;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

class AjaxManager
{
    /** @var  Registry */
    protected $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getResponse($currencyId, $date)
    {
        $currency = $this->getCurrency($currencyId);
        $name = $currency->getName();
        $currencyDate = $this->getCurrencyDate($currency);
        $arrayDate = [];
        /** @var CurrencyDate $item */
        foreach ($currencyDate as $item) {
            $arrayDate[] = $item->getExchangeDate()->format('Y-n-j');
        }
        if (array_key_exists($date, array_flip($arrayDate))) {
            $rate = $item->getRate();

            return "On this date $date of the selected currency $name the value $rate";
        }

        return "Sorry we do not have data for currency $name on the $date";
    }

    /**
     * @param $currencyId
     *
     * @return Currency
     */
    protected function getCurrency($currencyId)
    {
        return $this
            ->doctrine
            ->getRepository("AcmeCurrencyBundle:Currency")
            ->find($currencyId);
    }

    /**
     * @param Currency $currency
     *
     * @return \Acme\CurrencyBundle\Entity\CurrencyDate[]|array
     */
    protected function getCurrencyDate(Currency $currency)
    {
        return $this
            ->doctrine
            ->getRepository("AcmeCurrencyBundle:CurrencyDate")
            ->findBy(
                [
                    'currency' => $currency
                ]
            );
    }
}