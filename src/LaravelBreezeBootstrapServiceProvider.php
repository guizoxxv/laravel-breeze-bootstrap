<?php

namespace Guizoxxv\LaravelBreezeBootstrap;

use Illuminate\Support\ServiceProvider;
use Laravel\Breeze\Console\InstallCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class LaravelBreezeBootstrapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        InstallCommand::macro('bootstrap', function (InstallCommand $command) {
            $breeze_stubs_path = base_path('vendor/laravel/breeze/stubs/default');
            $stubs_path = __DIR__ . '/../stubs';

            // NPM Packages...
            $command->updateNodePackages(function ($packages) {
                return [
                    'bootstrap' => '^5.2.3',
                    '@popperjs/core' => '^2.11.6',
                    'sass' => '^1.56.1',
                ] + $packages;
            });

            // Controllers...
            (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers'));
            (new Filesystem)->copyDirectory($breeze_stubs_path . '/app/Http/Controllers', app_path('Http/Controllers'));

            // Requests...
            (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
            (new Filesystem)->copyDirectory($breeze_stubs_path . '/app/Http/Requests', app_path('Http/Requests'));

            // Views...
            (new Filesystem)->ensureDirectoryExists(resource_path('views'));
            (new Filesystem)->copyDirectory($stubs_path . '/resources/views', resource_path('views'));

            if (!$command->option('dark')) {
                $command->removeDarkClasses((new Finder)
                        ->in(resource_path('views'))
                        ->name('*.blade.php')
                        ->notName('welcome.blade.php')
                );
            }

            // Components...
            (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
            (new Filesystem)->copyDirectory($breeze_stubs_path . '/app/View/Components', app_path('View/Components'));

            // Tests...
            $command->installTests();

            // Routes...
            copy($breeze_stubs_path . '/routes/web.php', base_path('routes/web.php'));
            copy($breeze_stubs_path . '/routes/auth.php', base_path('routes/auth.php'));

            // "Dashboard" Route...
            $command->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
            $command->replaceInFile('Home', 'Dashboard', resource_path('views/welcome.blade.php'));
            $command->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

            // Vite
            copy($stubs_path . '/vite.config.js', base_path('vite.config.js'));

            // Sass
            (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
            copy($stubs_path . '/resources/sass/_variables.scss', resource_path('sass/_variables.scss'));
            copy($stubs_path . '/resources/sass/app.scss', resource_path('sass/app.scss'));

            // Bootstraping
            copy($stubs_path . '/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));

            $command->line('');
            $command->info('Breeze scaffolding installed successfully.');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
