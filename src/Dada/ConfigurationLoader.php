<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: david
 * Date: 18/04/2017
 * Time: 07:17
 */

namespace Dada;

use Phar;

/**
 * Class ConfigurationLoader
 * @package Dada
 *
 * Loads configuration and check it
 */
class ConfigurationLoader
{

    public function load() : bool
    {
        $file = null;
        $config = null;
        if (getopt('c:', ['config:'])) {
            if (getopt('c:')) {
                $file = getopt('c:')['c'];
            } else {
                $file = getopt('', ['config:'])['config'];
            }
            try {
                Phar::mount('userConfig.ini', $file);
            } catch (\Exception $e) {
                echo 'Unable to load settings.  Please check path.';
                return false;
            }
            $config = @parse_ini_file($file);
            if (!$config) {
                echo 'Configuration file is invalid.  Please check it!';
                return false;
            }
        }
        // Load default config and merge it with new one (if new one is given)
        $defaultConfig = parse_ini_file('config.ini');
        return $this->checkConfig(($config) ? array_merge($defaultConfig, $config) : $defaultConfig);
    }

    private function checkConfig(array $config) : bool
    {
        // Checking all keys individually
        var_dump(scandir(getopt('d:')));
        return true;
    }
}