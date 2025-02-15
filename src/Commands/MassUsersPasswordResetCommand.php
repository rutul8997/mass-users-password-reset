<?php

namespace Rutul\MassUsersPasswordReset\Commands;

use Illuminate\Console\Command;

class MassUsersPasswordResetCommand extends Command
{
    public $signature = 'mass-users-password-reset';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
