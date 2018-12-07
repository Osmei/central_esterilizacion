<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once '../Service/OperadorCEService.php';

class OperadorCEController
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function init()
    {
        $this->app->group('/api', function () {
            $this->group('/operadoresCE', function () {
                $this->get('', function (Request $request, Response $response) {
                    
                    $service = new OperadorCEService();
                    $items = $service->getAll();

                    return $response->withJson($items, 200);
                });
                $this->get('/{id}', function(Request $request, Response $response) {
                    $id = $request->getAttribute('id');
                    $service = new OperadorCEService();
                    $operadorCE = $service->get($id);
                    if ($operadorCE == null) {
                        return $response->withStatus(204);
                    }
                    return $response->withJson($operadorCE, 200);
                });

            });
        });
    }
}