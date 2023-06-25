<?php

namespace app\routes;

use Slim\Psr7\NonBufferedBody;
use app\controllers\HomeController;
use app\controllers\SseController;
use app\controllers\UserController;

// Abaixo são adicionadas as rotas da api

// Rota default
$app->get('/', [HomeController::class, 'index']);

// Rota Server Sent Events
$app->get('/sse', [SseController::class, 'sse']);

// Rota users
$app->get('/users', [UserController::class, 'index']);