<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once '../Service/ProveedorService.php';

class ProveedorController
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function init()
    {
        $this->app->group('/api', function () {
            $this->group('/proveedores', function () {
                $this->get('', function (Request $request, Response $response) {
                    $service = new ProveedorService();
                    $items = $service->getAll();

                    return $response->withJson($items, 200);
                });
                $this->get('/{id}', function(Request $request, Response $response) {
                    $id = $request->getAttribute('id');
                    $service = new ProveedorService();
                    $proveedor = $service->get($id);
                    if ($proveedor == null) {
                        return $response->withStatus(204);
                    }
                    return $response->withJson($proveedor, 200);
                });

            });
        });
    }
}