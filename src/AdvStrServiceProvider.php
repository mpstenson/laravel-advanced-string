<?php

namespace mpstenson\AdvStr;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AdvStrServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        if (config('advanced-string.use_str') === true) {
            foreach (get_class_methods(AdvStr::class) as $methodName) {
                Str::macro($methodName, function () use ($methodName) {
                    $args = func_get_args();

                    return (new AdvStr)->$methodName(...$args);
                });
            }
        }
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-advanced-string')
            ->hasConfigFile();
    }
}
