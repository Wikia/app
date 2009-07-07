<?php
// TODO extension credits

$class = "ApiUploadLogo";
$wgAutoloadClasses[$class] = dirname(__FILE__) . '/' . $class . '.php';
$wgAPIModules['uploadlogo'] = 'ApiUploadLogo';

