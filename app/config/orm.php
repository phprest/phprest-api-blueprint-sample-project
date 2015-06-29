<?php

$ormConfig = new \Phprest\Service\Orm\Config(
    [
        'driver'            => 'pdo_mysql',
        'host'              => 'localhost',
        'dbname'            => 'tesselboard',
        'charset'           => 'utf8',
        'user'              => 'root',
        'password'          => 'root'
    ],
    [__DIR__ . '/../../api']
);

$ormConfig->migration = new \Phprest\Service\Orm\Config\Migration(__DIR__ . '/../orm/migrations');
$ormConfig->fixture = new \Phprest\Service\Orm\Config\Fixture(__DIR__ . '/../orm/fixtures');

return $ormConfig;
