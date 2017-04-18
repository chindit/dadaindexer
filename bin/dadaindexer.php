#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use DadaIndexer\DadaIndexer;
use Symfony\Component\Console\Application;

$application = new Application('DadaIndexer', '0.1-dev');
$application->add(new DadaIndexer());
$application->run();