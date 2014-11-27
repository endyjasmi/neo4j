<?php

echo 'Auto generating neo4j status code file' . PHP_EOL;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(dirname(__FILE__)));
define('BIN_DIR', ROOT_DIR . DS . 'bin');
define('SRC_DIR', ROOT_DIR . DS . 'src');
define('TEMPLATE_DIR', BIN_DIR . DS . 'templates');
define('VENDOR_DIR', ROOT_DIR . DS . 'vendor');

require_once(BIN_DIR . DS . 'functions.php');
require_once(VENDOR_DIR . DS . 'autoload.php');

if (is_dir(SRC_DIR . DS . 'Neo4j' . DS . 'Error')) {
    echo 'Deleting previously generated status code files' . PHP_EOL;
    clean(SRC_DIR . DS . 'Neo4j' . DS . 'Error');
}

$neo4j = new \EndyJasmi\Neo4j;
$driver = $neo4j->driver();
$url = 'http://www.neo4j.com/docs/stable/status-codes.html';

echo 'Scraping neo4j documentation for status code' . PHP_EOL;
$codes = fetchStatusCodes($driver, $url);

echo 'Generating status tree' . PHP_EOL;
$tree = generateTree($codes);

$errors = [];
traverse($tree, function ($parent, $node) use (&$errors) {
    $errors[] = generateError($parent, $node);
});

echo 'Writing files' . PHP_EOL;
foreach ($errors as $error) {
    $template = loadTemplate();

    writeFile($template, $error);
}

echo 'Finish generating status code files' . PHP_EOL;
