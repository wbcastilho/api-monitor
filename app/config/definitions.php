<?php

namespace app\config;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use DI\autowire;
use app\models\Equipamento;
use app\models\User;

return [
    Connection::class => function () {
        $connectionParams = [
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => $_ENV['DB_CHARSET']
        ];
        return DriverManager::getConnection($connectionParams);
    },   
    Equipamento::class => \DI\autowire(Equipamento::class),
    User::class => \DI\autowire(User::class)
];