<?php
/**
 * Allows custom headers/footers to be added to user to user emails.
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:FormatEmail Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'FormatEmail',
	'version' => '1.0',
	'author' => 'Travis Derouin',
	'descriptionmsg' => 'email-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FormatEmail',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['EmailUser'] = $dir . 'FormatEmail.i18n.php';

$wgHooks['EmailUser'][] = 'wfFormatEmail';

function wfFormatEmail( &$to, &$from, &$subject, &$text ) {
	global $wgUser;
	
	$ul = $wgUser->getUserPage();
	$text = wfMsg( 'email_header' ) . $text .
			wfMsg( 'email_footer', $wgUser->getName(), $ul->getFullURL() );
	return true;
}
