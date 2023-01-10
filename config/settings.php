<?php

// Prestige
// define('APP_ROOT', __DIR__);

// Should be set to 0 in production
error_reporting(E_ALL);

// Should be set to '0' in production
ini_set('display_errors', '1');

// Prestige
// // Timezone
// date_default_timezone_set('Europe/Berlin');

// Settings
$settings = [];

// // Path settings
// $settings['root'] = dirname(__DIR__);

// Error Handling Middleware settings
$settings['error'] = [

    // Should be set to false in production
    'display_error_details' => true,

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,
];

// APIS
// // Database settings
// $settings['customers_api'] = [
//     'driver' => 'mysql',
//     'host' => '127.0.0.1',
//     'username' => 'root',
//     'database' => 'customers_api',
//     'password' => 'ikramatic123',
//     'charset' => 'utf8mb4',
//     'collation' => 'utf8mb4_unicode_ci',
//     'flags' => [
//         // Turn off persistent connections
//         PDO::ATTR_PERSISTENT => false,
//         // Enable exceptions
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         // Emulate prepared statements
//         PDO::ATTR_EMULATE_PREPARES => true,
//         // Set default fetch mode to array
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         // Set character set
//         PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
//     ],
// ];

// Prestige
// Database settings
$settings['db'] = [
    'driver' => 'pdo_mysql',
    'host' => '127.0.0.1',
    'port' => 3306,
    'dbname' => 'customers_api',
    'user' => 'root',
    'password' => 'ikramatic123',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci',
    'driverOptions' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => false,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_general_ci'
    ],
];

return $settings;