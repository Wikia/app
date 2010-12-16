<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension that adds Wikimedia specific functionality
 *
 * @addtogroup Extensions
 *
 * @copyright Copyright © 2008-2009, Tim Starling
 * @copyright Copyright © 2009, Siebrand Mazeland, Multichill
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'WikimediaMessages',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:WikimediaMessages',
	'author'         => array( 'Tim Starling', 'Siebrand Mazeland' ),
	'description'    => 'Wikimedia specific messages',
	'descriptionmsg' => 'wikimediamessages-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WikimediaMessages'] = $dir .'WikimediaMessages.i18n.php';
$wgExtensionFunctions[] = 'wfSetupWikimediaMessages';

include_once ( $dir .'WikimediaGrammarForms.php' );

function wfSetupWikimediaMessages() {
	global $wgRightsUrl, $wgHooks;
	if( $wgRightsUrl == 'http://creativecommons.org/licenses/by-sa/3.0/' ) {
		// Override with Wikimedia's site-specific copyright message defaults
		// with the CC/GFDL semi-dual license fun!
		$wgHooks['SkinCopyrightFooter'][] = 'efWikimediaSkinCopyrightFooter';
		$wgHooks['EditPageCopyrightWarning'][] = 'efWikimediaEditPageCopyrightWarning';
		$wgHooks['EditPageTosSummary'][] = 'efWikimediaEditPageTosSummary';
	}
}

function efWikimediaEditPageCopyrightWarning( $title, &$msg ) {
	$msg = 'wikimedia-copyrightwarning';
	return true;
}

function efWikimediaSkinCopyrightFooter( $title, $type, &$msg, &$link ) {
	if( $type != 'history' ) {
		$msg = 'wikimedia-copyright';
	}
	return true;
}

function efWikimediaEditPageTosSummary( $title, &$msg ) {
	$msg = 'wikimedia-editpage-tos-summary';
	return true;
}
