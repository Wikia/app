<?php
if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */


require_once('UserMailer.php');

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ContactForm'] = $dir . 'SpecialContact.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['ContactForm2'] = $dir . 'SpecialContact.i18n.php';
$wgExtensionMessagesFiles['ContactForm2Aliases']  = $dir . 'SpecialContact.alias.php';

#$wgSpecialPages['ContactForm'] = 'ContactForm'; # Let MediaWiki know about your new special page.
extAddSpecialPage( $dir . 'SpecialContact.body.php', 'Contact', 'ContactForm' );

$wgSpecialPageGroups['Contact'] = 'wikia';

require_once( $dir . "SecMap.php" );
