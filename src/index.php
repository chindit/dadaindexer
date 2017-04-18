<?php
declare(strict_types = 1);

require_once "phar://dadaindexer.phar/AppManager.php";

$config = parse_ini_file("config.ini");
Phar::interceptFileFuncs();

AppManager::run();

