<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MyExtension/MyExtension.php" );
EOT;
	exit( 1 );
}

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('WikiaInternalHooks', $dir . 'WikiaInternalHooks.class.php');

/**
 * hooks
 */
$app->registerHook('AfterCheckInitialQueries', 'WikiaInternalHooks', 'onAfterCheckInitialQueries');

/**
* message files
*/
$app->registerExtensionMessageFile('WikiaInternal', $dir . 'WikiaInternal.i18n.php');


/**
 * Factory config
 */
F::addClassConstructor( 'WikiaInternalHooks', array( 'app' => $app ) );