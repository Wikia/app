<?php

define('APP_ROOT', __DIR__ . '/../../');

$loader = require APP_ROOT . 'vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);
