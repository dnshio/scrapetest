<?php
require_once __DIR__ . "/../vendor/autoload.php";

set_time_limit(0);

use Sainsburys\Command\ScrapeCommand;

$savePath = __DIR__ .'/../output/products.json';
$command = new ScrapeCommand($savePath);
$command->run();