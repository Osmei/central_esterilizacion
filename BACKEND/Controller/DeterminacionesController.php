<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Http\UploadedFile;

require_once '../Service/DeterminacionesService.php';
require_once '../Commons/Slim/ValidatePermissionsMiddleware.php';
require_once '../Service/PerfilesService.php';
require_once '../Model/Perfil.php';
require_once '../Model/Determinacion.php';


class DeterminacionesController extends AbstractRepository
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function init() {
        $this->app->group('/api', function () {
            $this->group('/determinaciones', function () {

                $this->get('', function (Request $request, Response $response) {
                    $determinacionService = new DeterminacionesService();
                    $determinaciones = $determinacionService->getAll();

                    return $response->withJson($determinaciones, 200);
                })->add(new ValidatePermissionsMiddleware([
                    "DETERMINACIONES_LISTAR"
                ]));

                $this->get('/grilla', function(Request $request, Response $response) {
                    $determinacionService = new DeterminacionesService();
                    $determinaciones = $determinacionService->grilla();

                    return $response->withJson($determinaciones, 200);
                })->add(new ValidatePermissionsMiddleware([
                    "DETERMINACIONES_LISTAR"
                ]));

                $this->get('/{id}', function(Request $request, Response $response) {
                    $id = $request->getAttribute('id');
                    $determinacionService = new DeterminacionesService();
                    $determinacion = $determinacionService->get($id);

                    if ($determinacion == null) {
                        throw new BadUrlRequestException("No existe la determinación.");
                    }
                    return $response->withJson($determinacion, 200);
                })->add(new ValidatePermissionsMiddleware([
                    "DETERMINACIONES_OBTENER"
                ]));

                $this->post('', function(Request $request, Response $response) {
                    $determinacion = DeterminacionesController::getInstanceFromRequest($request);                    
                    $determinacionService = new DeterminacionesService();
                    $determinacion = $determinacionService->create($determinacion);
                    
                    return $response->withJson($determinacion, 201);
                })->add(new ValidatePermissionsMiddleware([
                    "DETERMINACIONES_CREAR"
                ]))->add(function($request, $response, $next) {
                    DeterminacionesController::validate($request);
                    return $next($request, $response);
                });

                $this->put('/{id}', function(Request $request, Response $response) {
                    $determinacion = DeterminacionesController::getInstanceFromRequest($request);
                    $determinacionesService = new DeterminacionesService();
                    
                    $id = $request->getAttribute('id');
                    $determinacionn = $determinacionesService->get($id);                   
                    if($determinacionn == null){
                        throw new BadUrlRequestException("No existe la determinación.");
                    }

                    return $response->withJson($determinacionesService->update($determinacion), 204);
                })->add(new ValidatePermissionsMiddleware([
                    "DETERMINACIONES_ACTUALIZAR"
                ]))->add(function($request, $response, $next) {
                    DeterminacionesController::validate($request);
                    return $next($request, $response);
                });
            });
        });
    }

    private static function getInstanceFromRequest(Request $request): Determinacion {
    
        $determinacion = new Determinacion();

        $determinacion->setId((int)$request->getAttribute('id'));
        $determinacion->setTitulo($request->getParam('titulo'));
        $determinacion->setDescripcion($request->getParam('descripcion'));
        $determinacion->setActivo((bool)$request->getParam('activo'));
        
        return $determinacion;
    }

    private static function validate(Request $request): void {
        v::allOf(
            v::key('titulo', v::notEmpty()->StringType()->setName('Título')),
            v::key('descripcion', v::notEmpty()->StringType()->setName('Descripción')),
            v::key('activo', v::boolType()->setName('Activo'))
        )->assert($request->getParsedBody());
    }
}