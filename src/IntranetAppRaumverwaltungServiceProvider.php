<?php

namespace Hwkdo\IntranetAppRaumverwaltung;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Hwkdo\IntranetAppRaumverwaltung\Commands\IntranetAppRaumverwaltungCommand;

class IntranetAppRaumverwaltungServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('intranet-app-raumverwaltung')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_intranet_app_raumverwaltung_table')
            ->hasCommand(IntranetAppRaumverwaltungCommand::class);
    }
}
