#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__.'/vendor/autoload.php';

$application = new \Dada\DadaIndexer('dadaindexer', '0.0.1-dev');
$application->run();
