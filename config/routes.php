<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class);

    $app->get('/customers-data', \App\Action\HomeAction::class);

    $app->group(
        '/customers-data',
        function (RouteCollectorProxy $group) {

            $group->post('/', \App\Action\Customer\AddCustomer::class);
            $group->get('/', \App\Action\Customer\ListCustomer::class);
            $group->options('/', function (ServerRequestInterface $request, ResponseInterface $response) {
                return $response;
            }
            );

            $group->get('/{id}', \App\Action\Customer\ViewCustomer::class);
            $group->put('/{id}', \App\Action\Customer\UpdateCustomer::class);
            $group->delete('/{id}', \App\Action\Customer\DeleteCustomer::class);
            $group->options('/{id}', function (ServerRequestInterface $request, ResponseInterface $response) {
                return $response;
            }
            );
        }
    );

    $app->group(
        '/department-data',
        function (RouteCollectorProxy $group) {

            $group->post('/', \App\Action\Department\AddDepartment::class);
            $group->get('/', \App\Action\Department\ListDepartment::class);
            $group->options('/', function (ServerRequestInterface $request, ResponseInterface $response) {
                return $response;
            }
            );

            $group->get('/{id}', \App\Action\Department\ViewDepartment::class);
            $group->put('/{id}', \App\Action\Department\UpdateDepartment::class);
            $group->delete('/{id}', \App\Action\Department\DeleteDepartment::class);
            $group->options('/{id}', function (ServerRequestInterface $request, ResponseInterface $response) {
                return $response;
            }
            );
        }
    );
};