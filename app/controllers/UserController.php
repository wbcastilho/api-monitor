<?php

namespace app\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Doctrine\DBAL\Connection;
use app\models\User;

class UserController extends BaseController
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request, Response $response, $args)
    {                
        // $listUser = $this->user->findAll();       
        $listUser = $this->user->find(7);       

        return $this->ok($response, "Listado Usuários com DBAL", $listUser);        
    }  
}