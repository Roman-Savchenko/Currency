<?php

namespace Acme\CurrencyBundle\Tests\Unit\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;

use Acme\CurrencyBundle\Manager\CurrencyManager;
use Acme\CurrencyBundle\Entity\Currency;
use Acme\CurrencyBundle\Entity\CurrencyDate;

class CurrencyManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Registry */
    protected $registry;

    /** @var CurrencyManager */
    protected $currencyManager;

    public function setUp()
    {
        $this->registry = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyManager = new CurrencyManager(
            $this->registry
        );
    }

    public function testLoadCurrency()
    {
        $xml = new \SimpleXMLElement($this->xml());
        $entityRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->registry
            ->expects($this->any())
            ->method('getManager')
            ->willReturn($entityManager);

        $this->registry
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($entityRepository);

        $entityRepository->expects($this->any())->method('findAll')->willReturn(0);
        $entityManager->expects($this->any())->method('persist');
        $entityManager->expects($this->any())->method('flush');

        $expectedExpr = true;

        $expr = $this->currencyManager->getData($xml);
        $this->assertEquals($expectedExpr, $expr);

    }

    public function testLoadCurrencyAwareCurrency()
    {
        $xml = new \SimpleXMLElement($this->xml());
        $entityRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->registry
            ->expects($this->any())
            ->method('getManager')
            ->willReturn($entityManager);

        $this->registry
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($entityRepository);
        $currency = [
            '0' => $this->getCurrency(),
        ];

        $entityRepository->expects($this->any())->method('findAll')->willReturn($currency);
        $entityManager->expects($this->any())->method('persist');
        $entityManager->expects($this->any())->method('flush');

        $expectedExpr = true;

        $expr = $this->currencyManager->getData($xml);
        $this->assertEquals($expectedExpr, $expr);
    }

    public function testLoadCurrencyDateAtNewDay()
    {
        $xml = new \SimpleXMLElement($this->xml());
        $entityRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->registry
            ->expects($this->any())
            ->method('getManager')
            ->willReturn($entityManager);

        $this->registry
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($entityRepository);
        $currency = [
            '0' => $this->getCurrency(),
        ];

        $entityRepository->expects($this->any())->method('findAll')->willReturn($currency);

        $entityRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnCallback([$this, 'myCallback']));

        $entityManager->expects($this->any())->method('persist');
        $entityManager->expects($this->any())->method('flush');

        $expectedExpr = true;

        $expr = $this->currencyManager->getData($xml);
        $this->assertEquals($expectedExpr, $expr);
    }

    /**
     *
     * @return Currency|CurrencyDate
     */
    public function myCallback()
    {
        if (func_num_args() === 1) {

            return $this->getCurrency();
        } else {

            return $this->getCurrencyDate();
        }
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
        $date->format('05.08.2016');
        $currencyDayId = 1;
        $currencyDay = new CurrencyDate();
        $this->setId($currencyDay, $currencyDayId);
        $currencyDay->setCurrency(0.1234);
        $currencyDay->setExchangeDate($date);

        return $currencyDay;
    }

    /**
     * @return string
     */
    protected function xml()
    {
        return
            "<?xml version='1.0' standalone='yes'?>
        <exchange>
            <currency>
                <r030>946</r030>
                <txt>Румунський лей</txt>
                <rate>6.173444</rate>
                <cc>RON</cc>
                <exchangedate>06.08.2016</exchangedate>
            </currency>
            <currency>
                <r030>682</r030>
                <txt>Саудівський рiял</txt>
                <rate>6.614902</rate>
                <cc>SAR</cc>
                <exchangedate>06.08.2016</exchangedate>
                </currency>
            </exchange>";
    }
}