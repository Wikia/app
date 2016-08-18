<?php

/**
 * SiteWideMessages
 *
 * A SiteWideMessages extension for MediaWiki
 * Provides an interface for sending messages seen on all wikis
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Daniel Grunwell (grunny)
 * @date 2008-01-09
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/SiteWideMessages/SpecialSiteWideMessages.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SiteWideMessages.\n";
	exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SiteWideMessages',
	'author' => array(
		'[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'[http://www.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]'
	),
	'descriptionmsg' => 'sidewidemessages-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SiteWideMessages'
);

$wgExtensionFunctions[] = 'SiteWideMessagesInit';
$wgExtensionMessagesFiles['SpecialSiteWideMessages'] = dirname(__FILE__) . '/SpecialSiteWideMessages.i18n.php';
$wgAjaxExportList[] = 'SiteWideMessagesAjaxDismiss';

if ( empty( $wgSWMSupportedLanguages ) ) $wgSWMSupportedLanguages = array( 'en' );

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialSiteWideMessages_body.php', 'SiteWideMessages', 'SiteWideMessages');
$wgSpecialPageGroups['SiteWideMessages'] = 'wikia';

$wgAutoloadClasses['SiteWideMessagesController'] =  __DIR__ . '/SiteWideMessagesController.class.php';

$wgResourceModules['ext.siteWideMessages.anon'] = array(
	'localBasePath' => __DIR__ . '/js',
	'remoteExtPath' => 'wikia/SiteWideMessages/js',
	'scripts' => 'SiteWideMessages.anon.js',
);

/**
 * Initialize hooks
 *
 */
function SiteWideMessagesInit() {
	global $wgSharedDB, $wgDontWantShared;
	//Include files ONLY when SharedDB is defined and desired.
	if (isset($wgSharedDB) && empty($wgDontWantShared)) {
		global $wgHooks;
		$wgHooks['WikiFactoryPublicStatusChange'][] = 'SiteWideMessagesPublicStatusChange';
		$wgHooks['SiteNoticeAfter'][] = 'SiteWideMessagesSiteNoticeAfter';

		// macbre: notifications for Oasis
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'SiteWideMessagesAddNotifications';
	}
}

/**
 * Load JS/CSS for extension
 *
 */
function SiteWideMessagesIncludeJSCSS( $skin, &$bottomScripts) {
	global $wgExtensionsPath;

	$bottomScripts .= "<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/SiteWideMessages/SpecialSiteWideMessages.js\"></script>";

	return true;
}


/**
 * Return a content of all user's messages and add CSS styles
 *
 */
function SiteWideMessagesGetUserMessagesContent( $dismissLink = true, $parse = true, $addJSandCSS = true ) {
	global $wgExtensionsPath, $wgOut, $wgUser;

	$content = SiteWideMessages::getAllUserMessages( $wgUser, $dismissLink );
	if ( !empty( $content ) ) {
		if ( $addJSandCSS ) {
			global $wgHooks;
			$wgHooks['SkinAfterBottomScripts'][] = 'SiteWideMessagesIncludeJSCSS';
			$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"$wgExtensionsPath/wikia/SiteWideMessages/SpecialSiteWideMessages.css\" />");
		}
		return $parse ? $wgOut->parse( $content ) : $content;
	}
	return '';
}

/**
 * Dismiss message via AJAX
 *
 */
function SiteWideMessagesAjaxDismiss($msgId) {
	$result = SiteWideMessages::dismissMessage($msgId);
	return is_bool($result) ? ($result ? '1' : '0') : $result;
}

/**
 * Show notification (in Monobook)
 *
 * @author grunny
 */
function SiteWideMessagesSiteNoticeAfter( &$siteNotice ) {
	global $wgUser;
	wfProfileIn(__METHOD__);
	if ( !( F::app()->checkSkin( 'oasis' ) ) && !$wgUser->isAnon() && !$wgUser->isAllowed('bot') ) {
		$siteNotice .= SiteWideMessagesGetUserMessagesContent();
	}
	wfProfileOut(__METHOD__);
	return true;
}

/**
 * Show notification (in Oasis)
 *
 * @author macbre
 */
function SiteWideMessagesAddNotifications( Skin $skin, &$tpl ) {
	global $wgExtensionsPath;
	wfProfileIn(__METHOD__);
	$user = $skin->getUser();
	$out = $skin->getOutput();

	if ( F::app()->checkSkin( 'oasis' ) ) {
		// Add site wide notifications that haven't been dismissed
		if ( !$user->isLoggedIn() ) {
			$out->addModules( 'ext.siteWideMessages.anon' );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$msgs = SiteWideMessages::getAllUserMessages( $user, false, false );

		if ( !empty( $msgs ) ) {
			wfProfileIn( __METHOD__ . '::parse' );
			foreach ( $msgs as &$data ) {
				$data['text'] = $out->parse( $data['text'] );
			}
			wfProfileOut( __METHOD__ . '::parse' );

			wfRunHooks( 'SiteWideMessagesNotification', array( $msgs ) );

			$out->addScript( "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/wikia/SiteWideMessages/js/SiteWideMessages.tracking.js\"></script>" );
		}
	}

	wfProfileOut(__METHOD__);
	return true;
}

/**
 * When wiki is disabled or changed into the redirect, remove all messages from that wiki
 * User won't be able to do this by his own
 */
function SiteWideMessagesPublicStatusChange($city_public, $city_id, $reason = '') {
	if ($city_public == 0 || $city_public == 2) {
		SiteWideMessages::deleteMessagesOnWiki($city_id);
	}
	return true;
}

$wgHooks['UserRename::Global'][] = "SiteWideMessagesUserRenameGlobal";

function SiteWideMessagesUserRenameGlobal( $dbw, $uid, $oldusername, $newusername, $process, &$tasks ) {
	$tasks[] = array(
		'table' => 'messages_text',
		'username_column' => 'msg_recipient_name',
	);
	return true;
}
