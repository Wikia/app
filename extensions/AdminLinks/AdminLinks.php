<?php
/**
 * A special page holding special convenience links for sysops
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

// credits
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Admin Links',
	'version' => '0.1.2',
	'author' => 'Yaron Koren',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Admin_Links',
	'description' => 'A special page that holds helpful links for administrators',
	'descriptionmsg'  => 'adminlinks-desc',
);

$wgAdminLinksIP = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['AdminLinks'] = $wgAdminLinksIP . 'AdminLinks.i18n.php';
$wgSpecialPages['AdminLinks'] = 'AdminLinks';
$wgHooks['PersonalUrls'][] = 'AdminLinks::addURLToUserLinks';
$wgAvailableRights[] = 'adminlinks';
// by default, sysops see the link to this page
$wgGroupPermissions['sysop']['adminlinks'] = true;
$wgAutoloadClasses['AdminLinks']
	= $wgAutoloadClasses['ALTree']
	= $wgAutoloadClasses['ALSection']
	= $wgAutoloadClasses['ALRow']
	= $wgAutoloadClasses['ALItem']
	= $wgAdminLinksIP . 'AdminLinks_body.php';
$wgExtensionAliasesFiles['AdminLinks'] = $wgAdminLinksIP . 'AdminLinks.alias.php';
