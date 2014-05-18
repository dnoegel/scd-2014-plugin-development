<?php

namespace Shopware\Plugins\SwagScdExample\Commands;

use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Example of a simple CLI command
 *
 * Class SwagScdExampleCommand
 * @package Shopware\Plugins\SwagScdExample\Commands
 */
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
     * @param InputInterface $input         User input like arguments / options
     * @param OutputInterface $output       Output, e.g. printing a message
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