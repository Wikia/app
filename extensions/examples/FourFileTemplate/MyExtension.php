<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MyExtension/MyExtension.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'MyExtensionName',
	'version' => '0.1',
	'author' => 'MyExtensionAuthor',
	'url' => 'http://www.mediawiki.org/wiki/Extension:MyExtension',
	'descriptionmsg' => 'myextension-desc',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['MyExtension'] = $dir . 'MyExtension_body.php';
$wgSpecialPages['MyExtension'] = 'MyExtension';
$wgExtensionMessagesFiles['MyExtension'] = $dir . 'MyExtension.i18n.php';
$wgExtensionAliasesFiles['MyExtension'] = $dir . 'MyExtension.alias.php';
