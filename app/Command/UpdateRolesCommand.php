<?php

namespace App\Command;

use App\Constant\PermissionType;
use App\Models\Permission;
use App\Services\RoleService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:update-admin-roles',
    description: 'Add a short description for your command',
)]
class UpdateRolesCommand extends Command
{
    public function __construct(protected RoleService $roleService, string $name = null) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $permissions = PermissionType::getAllPermissions();

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'api');
        }

        $roleGroup = $this->roleService->getSuperAdminRoleGroup();

        $roleGroup->syncPermissions($permissions);

        $io->success('Roles Updated Successfully');

        return Command::SUCCESS;
    }
}
