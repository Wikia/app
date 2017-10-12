<?php
$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['AuthModalHooks'] = $dir . 'AuthModalHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'AuthModalHooks::onBeforePageDisplay';

/**
 * i18n
 */
