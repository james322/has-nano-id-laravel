<?php

namespace james322\HasNanoId;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HasNanoIdServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('has-nano-id-laravel')
            ->hasConfigFile('nano-id')
            ->hasMigration('create_has_nano_id_laravel_table');
    }
}
