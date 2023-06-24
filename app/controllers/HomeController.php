<?php

namespace app\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\NonBufferedBody;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response) 
    {        
        return $this->ok($response, "API-MONITOR", []); 
    }
}