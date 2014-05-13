<?php

namespace Shopware\Plugins\SwagScdExample\Commands;

use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SwagScdExampleCommand extends ShopwareCommand
{
    /**
     * Configure the command and its options/arguments
     */
    protected function configure()
    {
        $this
            ->setName('swagscdexample:example')
            ->setDescription('Run example command.')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Your name'
            )
            ->setHelp(<<<EOF
The <info>%command.name%</info> prints out your name.
EOF
            );
        ;
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $output->writeln("<info>{$name}</info>");

        // You can access the shopware container and any other shopware component from within the command
        $this->container->get('swagscdexample_mycomponent')->doStuff();
    }
}