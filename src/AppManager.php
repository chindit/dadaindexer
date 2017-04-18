<?php
declare(strict_types = 1);

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

use Dada\ConfigurationLoader;

class AppManager
{
    public static function run(): void
    {
        $configurationLoader = new ConfigurationLoader();
        if (!$configurationLoader->load()) {
            return;
        }

    }
}
