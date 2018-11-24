<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once '../Service/MetodoService.php';

class MetodoController
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function init()
    {
        $this->app->group('/api', function () {
            $this->group('/metodos', function () {
                $this->get('', function (Request $request, Response $response) {
                    $service = new MetodoService();
                    $items = $service->getAll();

                    return $response->withJson($items, 200);
                });
                $this->get('/{id}', function(Request $request, Response $response) {
                    $id = $request->getAttribute('id');
                    $service = new MetodoService();
                    $metodo = $service->get($id);
                    if ($metodo == null) {
                        return $response->withStatus(204);
                    }
                    return $response->withJson($metodo, 200);
                });

            });
        });
    }
}