<?php

namespace Egate\EgateOtp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Egate\EgateOtp\Commands\EgateOtpCommand;

class EgateOtpServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('egate-otp')
            ->hasConfigFile()
            ->hasMigration('create_egate-otp_table');

//            ->hasCommand(EgateOtpCommand::class);
    }
}
