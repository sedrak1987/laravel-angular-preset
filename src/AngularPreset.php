<?php

namespace SedrakSargsyan\AngularPreset;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;
use Illuminate\Support\Arr;

class AngularPreset extends Preset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updatePackages();
        static::updateWebpackConfiguration();

        tap(new Filesystem, function ($filesystem) {
            $filesystem->deleteDirectory(resource_path('js'));
            $filesystem->makeDirectory(resource_path('ts'));
            $filesystem->makeDirectory(resource_path('ts/app'));
            $filesystem->makeDirectory(resource_path('ts/environments'));
        });

        static::removeNodeModules();
        static::updateAngular();
    }

    /**
     * Update the given package array.
     *
     * @param  array $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
                '@angular/animations' => '~8.2.14',
                '@angular/common' => '~8.2.14',
                '@angular/compiler' => '~8.2.14',
                '@angular/core' => '~8.2.14',
                '@angular/forms' => '~8.2.14',
                '@angular/http' => '~8.2.14',
                '@angular/platform-browser' => '~8.2.14',
                '@angular/platform-browser-dynamic' => '~8.2.14',
                '@angular/router' => '~8.2.14',
                '@types/node' => '^12.0.0',
                'core-js' => '^2.5.4',
                'rxjs' => '~6.4.0',
                'ts-loader' => '^5.4.5',
                'tslib'=> '^1.10.0',
                'typescript' => '~3.5.3',
                'zone.js' => '~0.9.1',
            ] + Arr::except($packages, [
                'axios',
                'jquery',
                'vue-template-compiler',
                'vue',
                ]);
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__ . '/angular-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }
    
    /**
     * Update the Angular files.
     *
     * @return void
     */
    protected static function updateAngular()
    {
        copy(__DIR__ . '/angular-stubs/app/main.ts', resource_path('ts/main.ts'));
        copy(__DIR__ . '/angular-stubs/app/app.module.ts', resource_path('ts/app/app.module.ts'));
        copy(__DIR__ . '/angular-stubs/app/app.component.ts', resource_path('ts/app/app.component.ts'));
        copy(__DIR__ . '/angular-stubs/app/environment.ts', resource_path('ts/environments/environment.ts'));
        copy(__DIR__ . '/angular-stubs/app/tsconfig.json', resource_path('ts/tsconfig.json'));
        copy(__DIR__ . '/angular-stubs/app/tslint.json', resource_path('ts/tslint.json'));
        copy(__DIR__ . '/angular-stubs/app/welcome.blade.php', resource_path('views/welcome.blade.php'));
        copy(__DIR__ . '/angular-stubs/polyfills.ts', resource_path('ts/polyfills.ts'));
        copy(__DIR__ . '/angular-stubs/vendor.ts', resource_path('ts/vendor.ts'));
        copy(__DIR__ . '/angular-stubs/tsconfig.json', base_path('tsconfig.json'));
    }
}
