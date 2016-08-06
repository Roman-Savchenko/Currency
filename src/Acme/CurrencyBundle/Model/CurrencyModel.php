<?php

namespace Acme\CurrencyBundle\Model;

use Acme\CurrencyBundle\Entity\Currency;
use Acme\CurrencyBundle\Entity\CurrencyDate;

class CurrencyModel
{
    protected $id;

    /**
     * @var Currency
     */
    protected $currencyAbbreviation;

    /**
     * @var CurrencyDate
     */
    protected $date;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set currencyAbbreviation
     *
     * @param Currency $currencyAbbreviation
     *
     * @return CurrencyModel
     */
    public function setCurrencyAbbreviation(Currency $currencyAbbreviation)
    {
        $this->currencyAbbreviation = $currencyAbbreviation;

        return $this;
    }

    /**
     * Get currencyAbbreviation
     *
     * @return Currency
     */
    public function getCurrencyAbbreviation()
    {
        return $this->currencyAbbreviation;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CurrencyModel
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
