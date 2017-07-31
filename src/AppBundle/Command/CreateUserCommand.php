<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
	protected function configure() {
		$this
			->setName('app:create-admin')
			->setDescription('Creates admin user');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln('Creating Admin');

		$username = 'admin';
		$password = 'admin';

		$user = new User();
		$user->setUsername($username);
		$user->setEmail('admin@mdev.xyz');
		$user->setIsDisabled(false);
		$user->setPassword($this->getContainer()->get('security.password_encoder')->encodePassword($user, $password));
		$user->setCreatedOn(new \DateTime());
		$user->setUpdatedOn(new \DateTime());

		$orm = $this->getContainer()->get('doctrine.orm.entity_manager');

		$currentUsers = $orm->getRepository('AppBundle:User')->findByUsername('admin');
		foreach ($currentUsers as $cu) {
			$orm->remove($cu);
		}
		$orm->flush();

		$orm->persist($user);
		$orm->flush();

		$output->writeln('Admin user created. Username: ' . $username . ' Password: ' . $password);
	}
}