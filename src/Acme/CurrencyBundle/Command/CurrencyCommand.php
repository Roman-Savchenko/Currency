<?php

namespace Acme\CurrencyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CurrencyCommand extends ContainerAwareCommand
{
    /**
     * Console command configuration
     */
    public function configure()
    {
        $this->setName('currency:load');
        $this->setDescription('Loading data rates for the current date');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ContainerInterface $container */
        $container = $this->getContainer();
        $content = simplexml_load_file('http://bank.gov.ua/NBUStatService/v1/statdirectory/exchange');
        $result = $container->get('acme_currency.currency_manager')->getData($content);
        if ($result === true) {
            $output->writeln('<info>Exchange rates for the current date successfully written</info>');
            $output->writeln('');
        }

        return 0;
    }
}
