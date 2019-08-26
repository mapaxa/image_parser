<?php

require_once 'index.php';

use Parser\Classes\ReportController;

$report = new ReportController();
$report->show($domain);