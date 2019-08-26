<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

use Parser\Components\Db;

require_once __DIR__ . '/vendor/autoload.php';
define('ROOT', dirname(__FILE__));


$tables = [
    'urls',
    'pages',
    'images',
    ];

foreach ($tables as $table) {
  $db = \Parser\Components\Db::getConnection();
  $sql = "delete from {$table}";
  $db->exec($sql);
}


