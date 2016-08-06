<?php

namespace Acme\CurrencyBundle\Tests\Unit\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;

use Acme\CurrencyBundle\Manager\AjaxManager;
use Acme\CurrencyBundle\Entity\Currency;
use Acme\CurrencyBundle\Entity\CurrencyDate;

class AjaxManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Registry */
    protected $registry;

    /** @var AjaxManager */
    protected $ajaxManager;

    public function setUp()
    {
        $this->registry = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $this->ajaxManager = new AjaxManager(
            $this->registry
        );
    }

    public function testValueFound()
    {
        $currencyId = 1;
        $date = "2016-8-6";
        $entityRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->registry
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($entityRepository);

        $currencyDate = [
          '0' => $this->getCurrencyDate()
        ];

        $entityRepository->expects($this->any())->method('find')->willReturn($this->getCurrency());
        $entityRepository->expects($this->any())->method('findBy')->willReturn($currencyDate);
        $name = $this->getCurrency()->getName();
        $rate = $this->getCurrencyDate()->getRate();

        $expectedExpr = "On this date $date of the selected currency $name the value $rate";

        $expr = $this->ajaxManager->getResponse($currencyId, $date);
        $this->assertEquals($expectedExpr, $expr);

    }

    public function testValueNotFound()
    {
        $currencyId = 1;
        $date = "2016-8-5";
        $entityRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->registry
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($entityRepository);
        $name = $this->getCurrency()->getName();
        $date = "2016-8-5";
        $currencyDate = [
            '0' => $this->getCurrencyDate()
        ];

        $entityRepository->expects($this->any())->method('find')->willReturn($this->getCurrency());
        $entityRepository->expects($this->any())->method('findBy')->willReturn($currencyDate);

        $expectedExpr = "Sorry we do not have data for currency $name on the $date";

        $expr = $this->ajaxManager->getResponse($currencyId, $date);
        $this->assertEquals($expectedExpr, $expr);
    }

    /**
     * @param mixed $obj
     * @param mixed $val
     */
    protected function setId($obj, $val)
    {
        $class = new \ReflectionClass($obj);
        $prop = $class->getProperty('id');
        $prop->setAccessible(true);

        $prop->setValue($obj, $val);
    }

    /**
     * @return Currency
     */
    protected function getCurrency()
    {
        $currencyId = 1;
        $currency = new Currency();
        $this->setId($currency, $currencyId);
        $currency->setCurrencyKey('r030');
        $currency->setCurrencyAbbreviation('KZT');
        $currency->setName('Теньге');

        return $currency;
    }

    /**
     * @return CurrencyDate
     */
    protected function getCurrencyDate()
    {
        $date = new \DateTime();
        $date->format('6.8.2016');
        $currencyDayId = 1;
        $currencyDay = new CurrencyDate();
        $this->setId($currencyDay, $currencyDayId);
        $currencyDay->setCurrency(0.1234);
        $currencyDay->setExchangeDate($date);
        $currencyDay->setCurrency($this->getCurrency());

        return $currencyDay;
    }
}