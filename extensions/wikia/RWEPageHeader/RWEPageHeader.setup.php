<?php
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'RWEPageHeaderController' ] = $dir . 'RWEPageHeaderController.class.php';
$wgAutoloadClasses[ 'RWEPageHeaderHooks' ] = __DIR__ . '/RWEPageHeaderHooks.php';

//hooks
$wgHooks[ 'BeforePageDisplay' ][] = 'RWEPageHeaderHooks::onBeforePageDisplay';