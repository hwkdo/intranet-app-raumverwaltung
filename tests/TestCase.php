<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Tests;

use Hwkdo\IntranetAppRaumverwaltung\IntranetAppRaumverwaltungServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Hwkdo\\IntranetAppRaumverwaltung\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            IntranetAppRaumverwaltungServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $migration = include __DIR__.'/../database/migrations/2024_11_19_092328_create_app_raumverwaltung_standorts_table.php';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/2024_11_19_092329_create_app_raumverwaltung_gebaeudes_table.php';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/2024_11_19_092330_create_app_raumverwaltung_etages_table.php';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/2024_11_19_092914_create_app_raumverwaltung_nutzungsarts_table.php';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/2024_11_19_092915_create_app_raumverwaltung_fachbereichs_table.php';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/2024_11_19_092915_create_app_raumverwaltung_raums_table.php';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/2025_01_27_103610_add_deleted_at_to_app_raumverwaltung_raums_table.php';
        $migration->up();
    }
}
