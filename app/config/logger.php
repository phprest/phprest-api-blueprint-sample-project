<?php

use Phprest\Service\Logger\Config as LoggerConfig;
use Monolog\Handler\StreamHandler;

/** @var \Phprest\Application $app */

/** @var \Monolog\Logger $logger */
$logger = $app->getContainer()->get(LoggerConfig::getServiceName());

$logger->pushHandler(
    new StreamHandler(__DIR__ . '/../storage/log', \Monolog\Logger::DEBUG)
);
