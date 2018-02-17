<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Service\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateUserCommand
 */
class CreateUserCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('api:create-user')
            ->setDescription('Creates new user in database.')
            ->setDescription('Allows you to create User and persist it into database.')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $email = $input->getArgument('email');

            $user = new User();
            $user->setEmail($email);

            /** @var EntityManager $em */
            $em = $this->getHelperSet()->get('entityManager')->getEntityManager();

            $em->persist($user);
            $em->flush($user);

            $output->writeln(sprintf('User successfully created: %s', $email));
        } catch (\Throwable $t) {
            $output->writeln(sprintf('User creation fail: %s', $t->getMessage()));
        }
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if (!$this->getHelperSet()->has('entityManager') ||
            !($this->getHelperSet()->get('entityManager') instanceof EntityManagerHelper)) {
            throw new \OutOfBoundsException('There is no setup for `entityManager` in helperSet.');
        }

        parent::initialize($input, $output);
    }
}

