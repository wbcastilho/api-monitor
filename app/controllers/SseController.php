<?php

namespace app\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\NonBufferedBody;

class SseController extends BaseController
{      
    public function teste(Request $request, Response $response) 
    {        
        // return $response->getBody()->write("teste");
        return $this->ok($response, "TESTE2", []); 
    }   

    public function sse(Request $request, Response $response)
    {
        ini_set('max_execution_time', 0);

        $response = $response
            ->withBody(new NonBufferedBody())
            ->withHeader('Content-Type', 'text/event-stream')
            ->withHeader('Content-Encoding', 'identity')
            ->withHeader('Cache-Control', 'no-cache')
            ->withHeader('X-Accel-Buffering', 'no')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS'); 

        $body = $response->getBody();

        while (1) {
            $now = date('Y-m-d H:i:s');
            // $event = sprintf("event: %s\ndata: %s\n\n", 'ping', json_encode(['time' => $now]));

            $strJson = json_encode(['time' => $now]);
                
            // Evento ultimos-eventos              
            $event = "event: ultimos-eventos\n"; 
            $event .= "data: {$strJson}\n\n";    
            // Fim do evento
                
            // Add a whitespace to the end
            $body->write($event . str_pad("", 15000));

            if (connection_aborted()) {
                break;
            }

            sleep(1);
        }

        return $response;
    }   
}