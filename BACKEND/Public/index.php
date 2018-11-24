<?php
require_once '../vendor/autoload.php';

require_once '../Commons/Slim/AuthMiddleware.php';
require_once '../Commons/Slim/CorsMiddleware.php';
require_once '../Commons/Errors/ApiError.php';
require_once '../Commons/Validation/ValidationTranslation.php';

use Respect\Validation\Exceptions\ValidationException as ValidationException;

$checkAuthentication = true;
date_default_timezone_set('America/Argentina/Buenos_Aires');


$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'addContentLengthHeader' => false
    ],
];
$container = new \Slim\Container($configuration);
$app = new \Slim\App($container);
//if($checkAuthentication) $app->add(new AuthMiddleware());
$app->add(new CorsMiddleware());

$container['notFoundHandler'] = function($container) {
    return function ($request, $response) use ($container){
        return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', '*')
            ->withHeader('Access-Control-Allow-Methods', '*')
            ->write(json_encode(new ApiError(4040, null)));
    };
};

$container['errorHandler'] = function($container) {
    return function ($request, $response, $exception) use ($container) {
        $ret = $container['response']
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', '*')
            ->withHeader('Access-Control-Allow-Methods', '*');

        switch (true) {
            case $exception instanceof PDOException:
                error_log($exception);
                $ret = $ret
                    ->withStatus(500)
                    ->write(json_encode(new ApiError(
                        5001,
                        array($exception->getMessage()
                    ))));
                break;

            case $exception instanceof BadRequestException:                    
                $ret = $ret
                    ->withStatus(400)
                    ->write(json_encode(new ApiError(
                        4000,                        
                        array($exception->getMessage()
                    ))));
                break;

            case $exception instanceof BadUrlRequestException:                    
                $ret = $ret
                    ->withStatus(404)
                    ->write(json_encode(new ApiError(
                        4004,                        
                        array($exception->getMessage()
                    ))));
                break;

            case $exception instanceof BadRequestMultipleException:                
                $ret = $ret
                    ->withStatus(400)
                    ->write(json_encode(new ApiError(
                        4000,                    
                        $exception->getMensajes()
                    )));
                break;

            case $exception instanceof ValidationException:            
                $ret = $ret
                    ->withStatus(400)
                    ->write(json_encode(new ApiError(
                        4000,
                        $exception->setParam('translator', 'ValidationTranslation::translate')->getMessages()
                    )));
                break;

            case $exception instanceof UnauthorizedException:
                $ret = $ret
                    ->withStatus(401)
                    ->write(json_encode($exception->getError()));
                break;

            case $exception instanceof ForbidenException:
                $ret = $ret
                    ->withStatus(403)
                    ->write(json_encode($exception->getError()));
                break;

            default:                
                error_log($exception);
                $ret = $ret
                    ->withStatus(500)
                    ->write(json_encode(new ApiError(
                        5000,
                        array($exception->getMessage()
                    ))));
                break;
        }
        return $ret;
    };
};

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

/*require_once '../Controller/AuthController.php';
(new AuthController($app))->init();*/

require_once '../Controller/EmpresaEsterilizadoraController.php';
(new EmpresaEsterilizadoraController($app))->init();

require_once '../Controller/MetodoController.php';
(new MetodoController($app))->init();

require_once '../Controller/OperadorCEController.php';
(new OperadorCEController($app))->init();

require_once '../Controller/ProveedorController.php';
(new ProveedorController($app))->init();



$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});

$app->run();

?>