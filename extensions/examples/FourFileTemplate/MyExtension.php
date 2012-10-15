<?php
/**
 * MyExtensionName -- short description of MyExtensionName goes here
 *
 * @file
 * @ingroup Extensions
 * @version 0.1
 * @author MyExtensionName <foo.bar@example.com>
 * @license http://licenses.example.com/foo Foo License, version 2+
 * @link http://www.mediawiki.org/wiki/Extension:MyExtension Documentation
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MyExtension/MyExtension.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'MyExtensionName',
	'version' => '0.1',
	'author' => 'MyExtensionAuthor', // You can use array for multiple authors
	'descriptionmsg' => 'myextension-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MyExtension',
);

// Autoload classes, set up the special page and i18n
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['MyExtension'] = $dir . 'MyExtension_body.php';
$wgSpecialPages['MyExtension'] = 'MyExtension';
$wgExtensionMessagesFiles['MyExtension'] = $dir . 'MyExtension.i18n.php';
$wgExtensionMessagesFiles['MyExtensionAlias'] = $dir . 'MyExtension.alias.php';
