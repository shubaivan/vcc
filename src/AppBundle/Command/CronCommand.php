<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:cron')
            ->setDescription('Runs cron jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Running cron');
    }
}
