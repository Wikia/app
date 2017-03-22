<?php
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'PremiumPageHeaderController' ] = $dir . 'PremiumPageHeaderController.class.php';
$wgAutoloadClasses[ 'PremiumPageHeaderHooks' ] = $dir . 'PremiumPageHeaderHooks.class.php';

//hooks
$wgHooks[ 'BeforePageDisplay' ][] = 'PremiumPageHeaderHooks::onBeforePageDisplay';
