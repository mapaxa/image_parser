<?php

require_once 'index.php';

use Parser\Classes\Image;
use Parser\Classes\ParseController;

$parser = new ParseController(new Image());
$parser->parse($domain);
