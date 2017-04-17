<?php
declare(strict_types = 1);

$srcRoot = "src";
$buildRoot = "build";

$phar = new Phar($buildRoot . "/dadaindexer.phar",
    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
    "dadaindexer.phar");
$phar["index.php"] = file_get_contents($srcRoot . "/index.php");
$phar["common.php"] = file_get_contents($srcRoot . "/common.php");
$phar["config.ini"] = file_get_contents($srcRoot . "/config.ini");
$phar->setStub($phar->createDefaultStub("index.php"));

copy($srcRoot . "/config.ini", $buildRoot . "/config.ini");

