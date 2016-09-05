<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions',  __DIR__.'/config/mysql.yml' );
$classLoader->register();

AnnotationRegistry::registerLoader([$loader, 'loadClass']);
return $loader;
