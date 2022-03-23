<?php

use Illuminate\Database\Capsule\Manager as Eloquent;

global $capsule;

$capsule = new Eloquent;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => DB_SERVER,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASS,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Setup the Eloquent ORM
$capsule->bootEloquent();