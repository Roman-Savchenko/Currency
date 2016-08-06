<?php

namespace Acme\CurrencyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="currency_date",
 *     indexes={
 * @ORM\Index(name="currency_id", columns={"currency_id"})}
 * )
 **/
class CurrencyDate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="float")
     */
    protected $rate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="exchange_date", type="date", nullable=false)
     */
    protected $exchangeDate;

    /**
     * @var Currency
     *
     * @ORM\ManyToOne(targetEntity="Acme\CurrencyBundle\Entity\Currency", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    protected $currency;

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
     * Set rate
     *
     * @param float $rate
     * @return CurrencyDate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set exchangeDate
     *
     * @param \DateTime $exchangeDate
     * @return CurrencyDate
     */
    public function setExchangeDate($exchangeDate)
    {
        $this->exchangeDate = $exchangeDate;

        return $this;
    }

    /**
     * Get exchangeDate
     *
     * @return \DateTime 
     */
    public function getExchangeDate()
    {
        return $this->exchangeDate;
    }

    /**
     * Set currency
     *
     * @param \Acme\CurrencyBundle\Entity\Currency $currency
     * @return CurrencyDate
     */
    public function setCurrency(\Acme\CurrencyBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \Acme\CurrencyBundle\Entity\Currency 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
