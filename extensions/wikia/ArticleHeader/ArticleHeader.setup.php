<?php
$dir = dirname( __FILE__ ) . '/';

// Controllers
$wgAutoloadClasses[ 'ArticleHeaderController' ] = $dir . 'ArticleHeaderController.class.php';

// Classes
$wgAutoloadClasses[ 'ArticleHeader\PageTitle' ] = $dir . 'PageTitle.class.php';

// Hooks
$wgAutoloadClasses[ 'ArticleHeader\Hooks' ] = $dir . 'Hooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'ArticleHeader\Hooks::onBeforePageDisplay';