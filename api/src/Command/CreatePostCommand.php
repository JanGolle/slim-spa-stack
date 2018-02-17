<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\Post;
use App\Entity\User;
use App\Service\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreatePostCommand
 */
class CreatePostCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('api:create-post')
            ->setDescription('Creates new post in database.')
            ->setDescription('Allows you to create Post and persist it into database.')
            ->addArgument('author.email', InputArgument::REQUIRED, 'Email of author')
            ->addArgument('title', InputArgument::REQUIRED, 'Title of post');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $email = $input->getArgument('author.email');
            $title = $input->getArgument('title');

            /** @var EntityManager $em */
            $em = $this->getHelperSet()->get('entityManager')->getEntityManager();

            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if (is_null($user)) {
                throw new \DomainException(sprintf('User with email "%s" does not exist.', $email));
            }

            $post = (new Post())
                ->setAuthor($user)
                ->setTitle($title);

            $em->persist($post);
            $em->flush($post);

            $output->writeln(sprintf('Post successfully created: "%s"', $title));
        } catch (\Throwable $t) {
            $output->writeln(sprintf('Post creation fail: %s', $t->getMessage()));
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

