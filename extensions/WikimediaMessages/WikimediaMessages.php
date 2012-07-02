<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension that adds Wikimedia specific functionality
 *
 * @file
 * @ingroup Extensions
 *
 * @copyright Copyright © 2008-2009, Tim Starling
 * @copyright Copyright © 2009, Siebrand Mazeland, Multichill
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'WikimediaMessages',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:WikimediaMessages',
	'author'         => array( 'Tim Starling', 'Siebrand Mazeland' ),
	'descriptionmsg' => 'wikimediamessages-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WikimediaMessages'] = $dir .'WikimediaMessages.i18n.php';
$wgExtensionFunctions[] = 'wfSetupWikimediaMessages';

include_once ( $dir .'WikimediaGrammarForms.php' );

function wfSetupWikimediaMessages() {
	global $wgRightsUrl, $wgHooks;
	if( strpos( $wgRightsUrl, 'creativecommons.org/licenses/by-sa/3.0' ) !== false ) {
		// Override with Wikimedia's site-specific copyright message defaults
		// with the CC/GFDL semi-dual license fun!
		$wgHooks['SkinCopyrightFooter'][] = 'efWikimediaSkinCopyrightFooter';
		$wgHooks['EditPageCopyrightWarning'][] = 'efWikimediaEditPageCopyrightWarning';
		$wgHooks['EditPageTosSummary'][] = 'efWikimediaEditPageTosSummary';
	}
}

function efWikimediaEditPageCopyrightWarning( $title, &$msg ) {
	$msg = array( 'wikimedia-copyrightwarning' );
	return true;
}

function efWikimediaSkinCopyrightFooter( $title, $type, &$msg, &$link, &$forContent ) {
	if( $type != 'history' ) {
		$msg = 'wikimedia-copyright';
		$forContent = false;
	}
	return true;
}

function efWikimediaEditPageTosSummary( $title, &$msg ) {
	$msg = 'wikimedia-editpage-tos-summary';
	return true;
}
