<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+
 * Allows custom headers/footers to be added to user to user emails.
 *
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:FormatEmail Documentation
 *
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfFormatEmailInit';

$wgExtensionCredits['other'][] = array(
	'name' => 'FormatEmail',
	'author' => 'Travis Derouin',
	'description' => 'Allows custom headers/footers to be added to user to user emails.',
	'descriptionmsg' => 'email-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:FormatEmail',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['EmailUser'] = $dir . 'FormatEmail.i18n.php';

$wgHooks['EmailUser'][] = 'wfFormatEmail';

function wfFormatEmailInit() {
	wfLoadExtensionMessages( 'EmailUser' );
}

function wfFormatEmail (&$to, &$from, &$subject, &$text ) {
	global $wgUser;
	$ul = $wgUser->getUserPage();
	$text = wfMsg('email_header') . $text . wfMsg('email_footer',$wgUser->getName(), $ul->getFullURL());
	return true;
}
