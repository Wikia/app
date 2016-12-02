<?php
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'RWEPageHeaderController' ] = $dir . 'RWEPageHeaderController.class.php';
$wgAutoloadClasses[ 'RWEPageHeaderHooks' ] = __DIR__ . '/RWEPageHeaderHooks.class.php';
$wgAutoloadClasses[ 'RWEContributeMenu' ] = __DIR__ . '/RWEContributeMenu.class.php';

//hooks
$wgHooks[ 'BeforePageDisplay' ][] = 'RWEPageHeaderHooks::onBeforePageDisplay';
