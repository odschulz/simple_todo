<?php

// TODO: Settings per environment.
$cnf['database']['connection_uri'] = 'sqlite:../src/db/api.sqlite3';
$cnf['database']['username'] = '';
$cnf['database']['password'] = '';
$cnf['database']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

$cnf['settings']['displayErrorDetails'] = TRUE;

return $cnf;
