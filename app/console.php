<?php
require_once __DIR__ . "/../vendor/autoload.php";

set_time_limit(0);

use Sainsburys\Command\ScrapeCommand;

$command = new ScrapeCommand();

$command->run();