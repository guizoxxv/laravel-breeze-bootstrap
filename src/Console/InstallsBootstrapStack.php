<?php

namespace Guizoxxv\LaravelBreezeBootstrap\Console;

use Illuminate\Filesystem\Filesystem;

trait InstallsBootstrapStack
{
    /**
     * Install the Blade Breeze stack.
     *
     * @return int|null
     */
    protected function installBootstrapStack()
    {
        $breeze_stubs_path = base_path('vendor/laravel/breeze/stubs/default');
        $stubs_path = __DIR__ . '/../../stubs';

        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
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

        // Tests...
        if (! $this->installTests()) {
            return 1;
        }

        // Routes...
        copy($breeze_stubs_path . '/routes/web.php', base_path('routes/web.php'));
        copy($breeze_stubs_path . '/routes/auth.php', base_path('routes/auth.php'));

        // "Dashboard" Route...
        $this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
        $this->replaceInFile('Home', 'Dashboard', resource_path('views/welcome.blade.php'));

        // Vite
        copy($stubs_path . '/vite.config.js', base_path('vite.config.js'));

        // Sass
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        copy($stubs_path . '/resources/sass/_variables.scss', resource_path('sass/_variables.scss'));
        copy($stubs_path . '/resources/sass/app.scss', resource_path('sass/app.scss'));

        // Bootstraping
        copy($stubs_path . '/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));

        $this->components->info('Installing and building Node dependencies.');

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }

        $this->line('');
        $this->components->info('Breeze scaffolding installed successfully.');
    }
}