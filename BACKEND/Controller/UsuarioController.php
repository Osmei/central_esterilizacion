<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Http\UploadedFile;

require_once '../Service/UsuariosService.php';
require_once '../Commons/Slim/ValidatePermissionsMiddleware.php';
require_once '../Service/PerfilesService.php';
require_once '../Model/Perfil.php';
require_once '../Model/Usuario.php';


class UsuarioController extends AbstractRepository
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function init() {
        $this->app->group('/api', function () {
            $this->group('/usuarios', function () {
                $this->get('/{id}', function(Request $request, Response $response) {
                    $id = $request->getAttribute('id');
                    $usuarioService = new UsuariosService();
                    $usuario = $usuarioService->get($id);

                    if ($usuario == null) {
                        return $response->withStatus(204);
                    }
                    return $response->withJson($usuario, 200);
                })->add(new ValidatePermissionsMiddleware([
                    "USUARIO_VISUALIZAR"
                ]));
                
                $this->get('', function (Request $request, Response $response) {
                    $usuarioService = new UsuariosService();
                    $usuarios = $usuarioService->getAll();
                    
                    return $response->withJson($usuarios, 200);
                })->add(new ValidatePermissionsMiddleware([
                    "USUARIO_LISTAR"
                ]));                

                $this->post('', function(Request $request, Response $response) {
                    $usuario = UsuarioController::getInstanceFromRequest($request);
                    $usuariosService = new UsuariosService();
                    $usuario = $usuariosService->create($usuario);

                    return $response->withJson($usuario, 201);
                })/*->add(function($request, $response, $next) {
                    UsuarioController::validate($request);
                    return $next($request, $response);
                })*/->add(new ValidatePermissionsMiddleware([
                    "USUARIO_CREAR"
                ]));

                $this->put('/{id}', function(Request $request, Response $response) {
                    $usuario = UsuarioController::getInstanceFromRequest($request);
                    $usuariosService = new UsuariosService();
                    
                    return $response->withJson($usuariosService->update($usuario), 204);
                })/*->add(function($request, $response, $next) {
                    PersonaController::validate($request);
                    return $next($request, $response);
                })*/->add(new ValidatePermissionsMiddleware([
                    "USUARIO_MODIFICAR"
                ]));
            });
        });
    }

    private static function getInstanceFromRequest(Request $request): Usuario {
    
        $usuario = new Usuario();
        $perfil = new Perfil();                

        $usuario->setId((int)$request->getAttribute('id'));
        $usuario->setNombre($request->getParam('nombre'));
        $usuario->setApellido($request->getParam('apellido'));
        $usuario->setUsuario($request->getParam('usuario'));
        $usuario->setClave($request->getParam('clave'));
        $perfil->setId($request->getParam('perfil')['id']);
        $usuario->setPerfil($perfil);
        $usuario->setLaboratorioId($request->getParam('laboratorioId'));
        $usuario->setActivo($request->getParam('activo'));                                        
        
        return $usuario;
    }

}