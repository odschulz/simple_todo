<?php

include '../vendor/autoload.php';
include '../src/settings.php';

// TODO: Set database connection object in App container instead of passing it and creating dependencies.
// TODO: Create custom exception and response handlers.
$dbc = new \PDO(
    $cnf['database']['connection_uri'],
    $cnf['database']['username'],
    $cnf['database']['username'],
    $cnf['database']['pdo_options']
);

$db_wrapper = new \DB\SimpleDbWrapper($dbc);

$app = new \Slim\App(["settings" => $cnf['settings']]);

new \Controllers\TasksController($app, $db_wrapper);

$app->run();
