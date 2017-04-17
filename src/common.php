<?php
declare(strict_types = 1);

class AppManager
{
    public static function run(): void
    {

        $config = self::getConfigFile();
        if (!$config) {
            return;
        }
    }

    private static function getConfigFile() : array
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
                return [];
            }
            $config = @parse_ini_file($file);
            if (!$config) {
                echo 'Configuration file is invalid.  Please check it!';
                return [];
            }
        }
        // Load default config and merge it with new one (if new one is given)
        $defaultConfig = parse_ini_file('config.ini');
        return ($config) ? array_merge($defaultConfig, $config) : $defaultConfig;
    }
}
