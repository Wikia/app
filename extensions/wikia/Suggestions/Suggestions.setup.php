<?php

$dir = dirname(__FILE__) . '/';
//classes
$wgAutoloadClasses['Suggestions'] =  $dir . 'Suggestions.class.php';

$wgHooks['BeforePageDisplay'][] = 'Suggestions::loadAssets';
