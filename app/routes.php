<?php
declare(strict_types=1);

use App\Application\Actions\Product as Actions;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        phpinfo();
        return $response;
    });

    $app->group('/products', function (Group $group) {
        $group->get('', Actions\ListProductsAction::class);
        $group->post('', Actions\NewProductAction::class);
        $group->get('/{id}', Actions\ViewProductAction::class);
        $group->put('/{id}', Actions\UpdateProductAction::class);
    });
};
