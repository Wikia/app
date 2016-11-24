<?php
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'RWEPageHeaderController' ] = $dir . 'RWEPageHeaderController.class.php';
$wgAutoloadClasses[ 'RWEPageHeaderHooks' ] = __DIR__ . '/RWEPageHeaderHooks.class.php';

$wgHooks[ 'BeforePageDisplay' ][] = 'RWEPageHeaderHooks::onBeforePageDisplay';
