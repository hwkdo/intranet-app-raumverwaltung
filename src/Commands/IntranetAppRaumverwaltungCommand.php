<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Commands;

use Illuminate\Console\Command;

class IntranetAppRaumverwaltungCommand extends Command
{
    public $signature = 'intranet-app-raumverwaltung';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
