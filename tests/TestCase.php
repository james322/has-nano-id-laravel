<?php

namespace james322\HasNanoId\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use james322\HasNanoId\HasNanoIdServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'james322\\HasNanoId\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            HasNanoIdServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_has_nano_id_laravel_table.php.stub';
        $migration->up();

    }
}
