<?php

$options = getopt('d:i:');
$domain = trim($options['d']);
if (isset($options['i']) && is_numeric($options['i'])) {
  define('MAX_ITERATIONS_DEFAULT', $options['i']);
} else {
  define('MAX_ITERATIONS_DEFAULT', 100);
}