<?php

namespace Acme\FoorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

class FooCommand extends ContainerAwareCommand
{
    /**
     * Console command configuration
     */
    public function configure()
    {
        $this->setName('foo:hello');
        $this->setDescription('Main chain member.');
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
        $textFoo = 'foo:hello is a master command of a command chain that has registered member commands';
        $textBar = 'bar:hi registered as a member of foo:hello command chain';
        $textFirst = 'Executing foo:hello command itself first:';
        $textOutput = 'Hello from Foo!';

        $logger->info($textFoo);
        $logger->info($textBar);
        $logger->info($textFirst);
        $logger->info($textOutput);
        $output->writeln('Hello from Foo!');
        $command = $this->getApplication()->find('bar:hi');

        $arguments = array(
            'command' => 'bar:hi'
        );

        $greetInput = new ArrayInput($arguments);
        $returnCode = $command->run($greetInput, $output);

    }
}
