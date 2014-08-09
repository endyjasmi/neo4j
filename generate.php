<?php

define('DS', DIRECTORY_SEPARATOR);

function write($file, $data) {
    $folder = explode('/', $file);
    array_pop($folder);
    $folder = implode('/', $folder);

    if (!is_dir($folder)) {
        mkdir($folder);
    }

    file_put_contents($file, $data);
}

function codes() {
    $codes = file_get_contents(dirname(__FILE__) . DS . 'codes.json');
    $array_codes = json_decode($codes);

    $codes = array();

    foreach ($array_codes as $code) {
        $part = explode('.', $code);

        $codes[$part[0]][$part[1]][$part[2]][$part[3]] = false;
    }

    return $codes;
}

function template($parent, $code) {
    $template = file_get_contents(dirname(__FILE__) . DS . 'template.php');

    $filename = str_replace('\\', '/', $parent . '/' . $code);
    $file = dirname(__FILE__) . DS . 'src' . DS . "Neo4j/StatusCodes{$filename}.php";
    $namespace = "EndyJasmi\Neo4j\StatusCodes{$parent}";
    $path = "EndyJasmi\Neo4j\StatusCodes{$parent}";
    $parent = array_pop(explode('\\', $parent));
    $error = $code;

    $template = str_replace('{namespace}', $namespace, $template);
    $template = str_replace('{path}', $path, $template);
    $template = str_replace('{parent}', $parent, $template);
    $template = str_replace('{error}', $error, $template);

    var_dump($file);
    // var_dump($template);

    write($file, $template);
}

function statusCodes($codes, $parent = "")
{
    foreach ($codes as $code => $exit) {
        // var_dump($parent .' - '. $code);

        template($parent, $code);

        if ($exit) {
            statusCodes($exit, $parent .'\\'.$code);
        }
    }
}

// write(dirname(__FILE__) . DS . 'hello' . DS . 'world', 'world');

statusCodes(codes());