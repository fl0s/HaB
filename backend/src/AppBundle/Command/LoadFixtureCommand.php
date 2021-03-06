<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixtureCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:fixture:load');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fm = $this->getContainer()->get('h4cc_alice_fixtures.manager');
        $baseDir = $this->getContainer()->getParameter('kernel.root_dir') . '/Resources/fixtures/';

        $objects = $fm->loadFiles([
            $baseDir . 'rescue_types.yml',
            $baseDir . 'rescue_providers.yml',
            $baseDir . 'evacuation_provider.yml',
            $baseDir . 'events.yml',
            $baseDir . 'rescues.yml',
            $baseDir . 'groups.yml',
            $baseDir . 'users.yml',
        ]);

        $fm->persist($objects, true);
    }
}
