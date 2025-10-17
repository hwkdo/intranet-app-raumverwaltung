<?php

namespace Hwkdo\IntranetAppRaumverwaltung;

use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Hwkdo\IntranetAppRaumverwaltung\Policies\RaumPolicy;
use Illuminate\Support\Facades\Gate;
use Livewire\Volt\Volt;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            // ->hasMigration('create_intranet_app_raumverwaltung_table')
            // ->hasRoute('web') #funk,tioniert nicht, muss trotzdem unten loadRoutesFrom machen
            ->discoversMigrations();
        // ->hasCommand(IntranetAppRaumverwaltungCommand::class);
    }

    public function boot(): void
    {
        parent::boot();

        Gate::policy(Raum::class, RaumPolicy::class);
        $this->app->booted(function () {
            Volt::mount(__DIR__.'/../resources/views/livewire');
        });
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Register Blade components
        $this->loadViewComponentsAs('intranet-app-raumverwaltung', [
            \Hwkdo\IntranetAppRaumverwaltung\View\Components\RaumverwaltungLayout::class,
        ]);
    }
}
