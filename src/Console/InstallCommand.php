<?php

namespace Guizoxxv\LaravelBreezeBootstrap\Console;

use Laravel\Breeze\Console\InstallCommand as VendorInstallCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends VendorInstallCommand
{
    use InstallsBootstrapStack;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'breeze-bootstrap:install
                            {--pest : Indicate that Pest should be installed}
                            {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Breeze controllers and resources using the Bootstrap stack';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        $this->addArgument(
            name: 'stack',
            default: 'bootstrap',
        );

        return $this->installBootstrapStack();
    }

    /**
     * Override vendor method to ignore it.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        return;
    }
}
