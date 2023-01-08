<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use App\Database\ConnectionProxy;
use Selective\BasePath\BasePathMiddleware;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    // prestige
    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $settings['display_error_details'],
            (bool) $settings['log_errors'],
            (bool) $settings['log_error_details']
        );
    },

    // // APIS
    // ConnectionProxy::class => function (ContainerInterface $container) {
    //     return new ConnectionProxy(
    //         $container->get('customers_api'),
    //     );
    // },

    // // APIS
    // 'customers_api' => function (ContainerInterface $container) {
    //     $settings = $container->get('settings')['customers_api'];

    //     $host = $settings['host'];
    //     $dbname = $settings['database'];
    //     $username = $settings['username'];
    //     $password = $settings['password'];
    //     $charset = $settings['charset'];
    //     $flags = $settings['flags'];
    //     $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

    //     return new PDO($dsn, $username, $password, $flags);
    // },

    // Prestige
    // Database connection
    Connection::class => function (ContainerInterface $container) {
        $config = new DoctrineConfiguration();
        $connectionParams = $container->get('settings')['db'];

        return DriverManager::getConnection($connectionParams, $config);
    },

    PDO::class => function (ContainerInterface $container) {
        return $container->get(Connection::class)->getWrappedConnection();
    },
];