<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once '../Service/MaterialService.php';

class MaterialController
{
    private $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function init(){
        $this->app->group('/api', function () {
            $this->group('/materiales', function () {

                $this->get('', function (Request $request, Response $response) {
                    $service = new MaterialService();
                    $instrumentales = $service->getAll();

                    return $response->withJson($instrumentales, 200);
                });

                $this->get('/{id}', function(Request $request, Response $response) {
                    $id = $request->getAttribute('id');
                    $service = new MaterialService();
                    $instrumental = $service->get($id);
                    if ($instrumental == null) {
                        return $response->withStatus(204);
                    }
                    return $response->withJson($instrumental, 200);
                });

                $this->post('', function(Request $request, Response $response) {
                    $material = MaterialController::getInstanceFromRequest($request);
                    
                    $materialService = new MaterialService();
                    $material = $materialService->create($material);

                    return $response->withJson($material, 201);
                })/*->add(function($request, $response, $next) {
                    MaterialController::validate($request);
                    return $next($request, $response);
                })*/;

            });
        });
    }

    private static function getInstanceFromRequest(Request $request): Material {
    
        $material = new Material();                

        $material->setId((int)$request->getAttribute('id'));
        $material->setOperador((int)$request->getParam(('operador')));
        $material->setFecha($request->getParam('fecha'));
        $material->setHora($request->getParam('hora'));
        $material->setPaciente($request->getParam('paciente'));
        $material->setNumeroHistoriaClinica($request->getParam('numeroHistoriaClinica'));
        $material->setDescripcionMaterial($request->getParam('descripcionMaterial'));
        $material->setMedicoSolicitante($request->getParam('medicoSolicitante'));
        $material->setPesoDeLaCaja($request->getParam('pesoDeLaCaja'));
        $material->setProveedor($request->getParam('proveedor'));
        $material->setEmpresa($request->getParam('empresa'));
        $material->setMetodo($request->getParam('metodo'));
        $material->setObservaciones($request->getParam('observaciones'));                          
        
        return $material;
    }
}