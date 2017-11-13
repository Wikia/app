<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MyExtension/MyExtension.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Piggyback',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'piggyback-desc',
	'version' => '0.0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Piggyback'
);

$dir = dirname(__FILE__) . '/';


$wgAutoloadClasses['Piggyback'] = $dir . 'Piggyback_body.php'; # Tell MediaWiki to load the extension body.

$wgExtensionMessagesFiles['Piggyback'] = $dir . 'Piggyback.i18n.php';
$wgExtensionMessagesFiles['PiggybackAliases'] = $dir . 'Piggyback.alias.php';

$wgSpecialPages['Piggyback'] = 'Piggyback'; # Let MediaWiki know about your new special page.

$wgSpecialPageGroups['Piggyback'] = 'users';
$wgLogRestrictions['piggyback'] = 'piggyback';
$wgLogTypes[] = 'piggyback';

$wgHooks['ContributionsToolLinks'][] = 'efPiggybackAddToolLinks';
function efPiggybackAddToolLinks( $id, $nt, &$tools ) {
	global $wgUser;

	if ( !$wgUser->isAllowed( 'piggyback' ) ) {
		return true;
	}

	$sk = RequestContext::getMain()->getSkin();

	$tools[] = $sk->linkKnown(
		SpecialPage::getTitleFor( 'Piggyback', $nt->getDBkey() ),
		'Piggyback'
	);

	return true;
}
