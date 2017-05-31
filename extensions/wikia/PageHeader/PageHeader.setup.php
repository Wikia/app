<?php
$dir = dirname( __FILE__ ) . '/';

// Controllers
$wgAutoloadClasses[ 'Wikia\PageHeader\PageHeaderController' ] = $dir . 'PageHeaderController.class.php';

// Classes
$wgAutoloadClasses[ 'Wikia\PageHeader\PageTitle' ] = $dir . 'PageTitle.class.php';

// Hooks
$wgAutoloadClasses[ 'Wikia\PageHeader\Hooks' ] = $dir . 'Hooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'Wikia\PageHeader\Hooks::onBeforePageDisplay';
