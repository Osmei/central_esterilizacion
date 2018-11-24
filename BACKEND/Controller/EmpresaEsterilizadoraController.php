<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once '../Service/EmpresaEsterilizadoraService.php';

class EmpresaEsterilizadoraController
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function init()
    {
        $this->app->group('/api', function () {
            $this->group('/empresasEsterilizadoras', function () {
                $this->get('', function (Request $request, Response $response) {
                    $service = new EmpresaEsterilizadoraService();
                    $items = $service->getAll();

                    return $response->withJson($items, 200);
                });
                $this->get('/{id}', function(Request $request, Response $response) {
                    $id = $request->getAttribute('id');
                    $service = new EmpresaEsterilizadoraService();
                    $empresaEsterilizadora = $service->get($id);
                    if ($empresaEsterilizadora == null) {
                        return $response->withStatus(204);
                    }
                    return $response->withJson($empresaEsterilizadora, 200);
                });

            });
        });
    }
}