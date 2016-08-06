<?php

namespace Acme\BarBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

class BarCommand extends ContainerAwareCommand
{
    /**
     * Console command configuration
     */
    public function configure()
    {
        $this->setName('bar:hi');
        $this->setDescription('Member of chain.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \InvalidArgumentException
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $logger LoggerInterface */
        $logger = $this->getContainer()->get('logger');
        $textMembers = 'Executing foo:hello chain members:';
        $textEndCommand = 'Execution of foo:hello chain completed.';
        $textOutput = 'Hi from Bar!';

        $logger->info($textMembers);
        $logger->info($textOutput);
        $output->writeln('Hi from Bar!');
        $logger->info($textEndCommand);
    }
}
