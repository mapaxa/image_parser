<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

ini_set('xdebug.max_nesting_level', 5000);
ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/cli_params.php';
