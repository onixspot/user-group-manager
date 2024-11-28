<?php

declare(strict_types=1);

namespace App\Command;

use App\Api as ServerApi;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test', description: 'Hello PhpStorm')]
class TestCommand extends Command
{
    public function __construct(
        private readonly ServerApi\UserApi $userApi,
        private readonly ServerApi\GroupApi $groupApi,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->userApi->createUser(['email' => 'test@example.com', 'name' => 'Test User']);
        $user = $this->userApi->getUser(2);
        $users = $this->userApi->getUsers();
        $groups = $this->groupApi->getGroups();

        return Command::SUCCESS;
    }
}
