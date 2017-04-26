#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$application = new \Dada\DadaIndexer('dadaindexer', '1.1.0');
$application->run();
