<?php

namespace Acme\CurrencyBundle\Manager;

use Acme\CurrencyBundle\Entity\Currency;
use Acme\CurrencyBundle\Entity\CurrencyDate;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

class CurrencyManager
{
    /** @var  Registry */
    protected $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param \SimpleXMLElement $content
     *
     * @return bool
     */
    public function getData(\SimpleXMLElement $content)
    {
        $em = $this->doctrine->getManager();
        $dataCurrency = $this->getAllCurrency();
        $abbreviations = $this->getAbbreviations($dataCurrency);
        foreach ($content->children() as $value) {
            if ($dataCurrency != false) {
                if (!array_key_exists($value->cc->__toString(), array_flip($abbreviations))) {
                    $this->createNewCurrency($value, $em);
                }
                foreach ($abbreviations as $abbreviation) {
                    if (!$this->getCurrencyDate($abbreviation, new \DateTime($value->exchangedate->__toString())) instanceof CurrencyDate) {
                        $this->createNewCurrencyDate($abbreviation, $value, $em);
                    }
                }
            } else {
                $this->createNewCurrency($value, $em);
            }
        }
        $em->flush();

        return true;
    }

    /**
     * @return array
     */
    protected function getAllCurrency()
    {
        $currency = $this->doctrine->getRepository("AcmeCurrencyBundle:Currency")->findAll();
        if (empty ($currency)) {
            return false;
        }

        return $currency;
    }

    /**
     * @param $dataCurrency
     *
     * @return array
     */
    protected function getAbbreviations($dataCurrency)
    {
        $abbreviations = [];
        /** @var Currency $item */
        foreach ($dataCurrency as $item) {
            $abbreviations[] = $item->getCurrencyAbbreviation();
        }

        return $abbreviations;
    }

    /**
     * @param \SimpleXMLElement $value
     * @param EntityManager $em
     */
    protected function createNewCurrency(\SimpleXMLElement $value, EntityManager $em)
    {
        $currency = new Currency();
        $currencyDate = new CurrencyDate();
        $currency->setName($value->txt->__toString());
        $currency->setCurrencyAbbreviation($value->cc->__toString());
        $currency->setCurrencyKey($value->r030->__toString());
        $currencyDate->setExchangeDate(new \DateTime($value->exchangedate->__toString()));
        $currencyDate->setRate($value->rate->__toString());
        $currencyDate->setCurrency($currency);
        $em->persist($currencyDate);
        $em->persist($currency);
    }

    /**
     * @param $abbreviation
     *
     * @return object
     */
    protected function getSingleCurrency($abbreviation)
    {
        return $this
            ->doctrine
            ->getRepository("AcmeCurrencyBundle:Currency")
            ->findOneBy(
                [
                    'currencyAbbreviation' => $abbreviation
                ]
            );
    }

    /**
     * @param string $abbreviation
     * @param \DateTime $date
     * @return object
     */
    protected function getCurrencyDate($abbreviation, \DateTime $date)
    {
        $singleCurrency = $this->getSingleCurrency($abbreviation);
        return $this
            ->doctrine
            ->getRepository("AcmeCurrencyBundle:CurrencyDate")
            ->findOneBy(
                [
                    'currency' => $singleCurrency,
                    'exchangeDate' => $date
                ]
            );
    }



    /**
     * @param string $abbreviation
     * @param \SimpleXMLElement $value
     * @param EntityManager $em
     */
    protected function createNewCurrencyDate($abbreviation, $value, EntityManager $em)
    {
        $singleCurrency = $this->getSingleCurrency($abbreviation);
        $currencyDate = new CurrencyDate();
        $currencyDate->setExchangeDate(new \DateTime($value->exchangedate->__toString()));
        $currencyDate->setRate($value->rate->__toString());
        $currencyDate->setCurrency($singleCurrency);
        $em->persist($currencyDate);
    }
}