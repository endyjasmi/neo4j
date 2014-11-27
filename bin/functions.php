<?php

function clean($directory)
{
    $parent = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($parent, RecursiveIteratorIterator::CHILD_FIRST);

    foreach ($files as $file) {
        if ($file->getFilename() === '.' || $file->getFilename() === '..') {
            continue;
        }

        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }

    rmdir($directory);
}

function fetchStatusCodes(\EndyJasmi\Neo4j\DriverInterface $driver, $url)
{
    // Validate arguments
    if (! is_string($url)) {
        throw new InvalidArgumentException('$url is not string.');
    }

    // Initial commit
    $codes = [];
    $crawler = new \Symfony\Component\DomCrawler\Crawler;

    // Get raw status code html page
    $content = $driver->getStatusCodesPage($url);

    // Parse html page and return codes
    $crawler->addContent($content);

    $crawler->filter('table')
        ->last()
        ->filter('code')
        ->each(function ($code) use (&$codes) {
            $codes[] = $code->text();
        });

    return $codes;
}

function generateError(array $parent, $code)
{
    $path = array_merge(['Neo4j', 'Error'], $parent);
    $namespace = array_merge(['EndyJasmi', 'Neo4j', 'Error'], $parent);
    $error = $code;
    $parent = count($namespace) < 4 ? ['Exception'] : $namespace;

    return [
        'file_path' => $path,
        'namespace' => implode('\\', $namespace),
        'parent_fqn' => implode('\\', $parent),
        'error' => $error,
        'parent_class' => array_pop($parent)
    ];
}

function generateTree(array $codes)
{
    $tree = [];

    foreach ($codes as $code) {
        $code = explode('.', $code);
        $tree[$code[0]][$code[1]][$code[2]][$code[3]] = false;
    }

    return $tree;
}

function loadTemplate()
{
    return file_get_contents(TEMPLATE_DIR . DS . 'error.php');
}

function traverse(array $tree, \Closure $callback, $parent = [])
{
    foreach ($tree as $node => $continue) {
        $callback($parent, $node);

        if ($continue) {
            $pass = $parent;
            $pass[] = $node;
            traverse($continue, $callback, $pass);
        }
    }
}

function writeFile($template, array $error)
{
    $folder = SRC_DIR . DS . implode(DS, $error['file_path']);

    if (! is_dir($folder)) {
        mkdir($folder);
    }

    $template = str_replace('{namespace}', $error['namespace'], $template);
    $template = str_replace('{parent_fqn}', $error['parent_fqn'], $template);
    $template = str_replace('{error}', $error['error'], $template);
    $template = str_replace('{parent_class}', $error['parent_class'], $template);

    $file = SRC_DIR . DS . implode(DS, $error['file_path']) . DS;
    $file .= "{$error['error']}.php";

    file_put_contents($file, $template);
}
