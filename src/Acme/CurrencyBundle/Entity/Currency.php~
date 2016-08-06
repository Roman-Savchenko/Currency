<?php

namespace Acme\CurrencyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="currency_entity",
 *     uniqueConstraints={
 *              @ORM\UniqueConstraint(name="currency_abbreviation", columns={"currency_abbreviation"})
 *      })
 **/
class Currency
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
     * @ORM\Column(name="currency_key", type="string", length=10)
     */
    protected $currencyKey;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="currency_abbreviation", type="string", length=10, nullable=false)
     */
    protected $currencyAbbreviation;

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
     * Set currencyKey
     *
     * @param string $currencyKey
     * @return Currency
     */
    public function setCurrencyKey($currencyKey)
    {
        $this->currencyKey = $currencyKey;

        return $this;
    }

    /**
     * Get currencyKey
     *
     * @return string 
     */
    public function getCurrencyKey()
    {
        return $this->currencyKey;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Currency
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set currencyAbbreviation
     *
     * @param string $currencyAbbreviation
     * @return Currency
     */
    public function setCurrencyAbbreviation($currencyAbbreviation)
    {
        $this->currencyAbbreviation = $currencyAbbreviation;

        return $this;
    }

    /**
     * Get currencyAbbreviation
     *
     * @return string 
     */
    public function getCurrencyAbbreviation()
    {
        return $this->currencyAbbreviation;
    }
}
