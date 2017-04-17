<?php
declare(strict_types = 1);

class AppManager
{
    public static function run(): void
    {

        $config = self::getConfigFile();
        var_dump($config);
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
            echo $file."\n";
            try {
                Phar::mount('userConfig.ini', $file);
            } catch (\Exception $e) {
                echo 'Unable to load settings.  Please check path.';
            }
            $config = @parse_ini_file($file);
            if (!$config) {
                echo 'Configuration file is invalid.  Please check it!';
                $config = [];
            }
        } else {
            $config = parse_ini_file('config.ini');
        }
        return $config;
    }
}
