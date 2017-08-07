<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\LockHandler;

class CardProcessCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:card:process')
            ->setDescription('Runs cron jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $container = $this->getContainer();

        $lockHandler = new LockHandler('CardProcessCommand.lock');
        if (!$lockHandler->lock()) {
            $io->warning('CardProcessCommand already locked (previous command in progress)');

            return;
        }

        try {
            $applicationVirtualCad = $container->get('app.application.virtual_cad');
            $applicationVirtualCad->proccess();
            $io->success('Process was sent successful');
        } catch (\Exception $e) {
            $io->warning('Failed Process');
        } finally {
            $io->success('Process was successful');
            $lockHandler->release();
        }
    }
}
