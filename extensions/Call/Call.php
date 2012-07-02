<?php
/**
 * @version 0.1
 * @version 0.2
 * added "return true;" at the end of wfCallLoadMessages()
 */
# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install Call as a special page, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/Call/Call.php" );
EOT;
	exit( 1 );
}

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['Call'] = $dir . 'Call_body.php';
$wgExtensionMessagesFiles['Call'] = $dir . 'Call.i18n.php';
$wgExtensionMessagesFiles['CallAlias'] = $dir . 'Call.alias.php';
$wgSpecialPages['Call'] = 'Call';

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Call',
	'version' => '1.2',
	'author' => 'Algorithmix',
	'descriptionmsg' => 'call-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Call',
);
