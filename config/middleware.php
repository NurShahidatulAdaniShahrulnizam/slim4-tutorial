<?php

use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use App\Middleware\CorsMiddleware;
use Selective\BasePath\BasePathMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(CorsMiddleware::class);

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    $app->add(BasePathMiddleware::class);

    // Handle exceptions
    $app->addErrorMiddleware(true, true, true);

    // Catch exceptions and errors
    $app->add(ErrorMiddleware::class);
};
