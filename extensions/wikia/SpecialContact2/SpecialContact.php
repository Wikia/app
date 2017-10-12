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
 
$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'SpecialContact',
	'author' => 'Wikia',
	'descriptionmsg' => 'specialcontact-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialContact2',
);

require_once('UserMailer.php');

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ContactForm'] = $dir . 'SpecialContact.body.php'; # Tell MediaWiki to load the extension body.

#$wgSpecialPages['ContactForm'] = 'ContactForm'; # Let MediaWiki know about your new special page.
extAddSpecialPage( $dir . 'SpecialContact.body.php', 'Contact', 'ContactForm' );

$wgSpecialPageGroups['Contact'] = 'wikia';

require_once( $dir . "SecMap.php" );
