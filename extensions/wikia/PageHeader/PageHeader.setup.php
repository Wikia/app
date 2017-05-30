<?php
$dir = dirname( __FILE__ ) . '/';

// Controllers
$wgAutoloadClasses[ 'PageHeaderController' ] = $dir . 'PageHeaderController.class.php';

// Classes
$wgAutoloadClasses[ 'PageHeader\PageTitle' ] = $dir . 'PageTitle.class.php';

// Hooks
$wgAutoloadClasses[ 'PageHeader\Hooks' ] = $dir . 'Hooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'PageHeader\Hooks::onBeforePageDisplay';