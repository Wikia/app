<?php
/**
 * Created on 24.6.2009
 *
 * Author: ning
 */
if ( !defined( 'MEDIAWIKI' ) ) die;

define( 'SMW_NM_VERSION', '0.5.3' );

$smwgNMIP = $IP . '/extensions/SemanticNotifyMe';
$smwgNMScriptPath = $wgScriptPath . '/extensions/SemanticNotifyMe';

$wgExtensionMessagesFiles['SemanticNotifyMe'] = $smwgNMIP . '/languages/SMW_NMLanguage.php';

global $wgExtensionFunctions;
$wgExtensionFunctions[] = 'smwgNMSetupExtension';

global $wgDefaultUserOptions;
$wgDefaultUserOptions['enotifyme'] = 1;

function smwfNMInitializeTables() {
	global $smwgNMIP;
	require_once( $smwgNMIP . '/includes/SMW_NMStorage.php' );
	NMStorage::getDatabase()->setup( true );

	return true;
}

function smwfNMGetAjaxMethodPrefix() {
	$func_name = isset( $_POST["rs"] ) ? $_POST["rs"] : ( isset( $_GET["rs"] ) ? $_GET["rs"] : NULL );
	if ( $func_name == NULL ) return NULL;
	return substr( $func_name, 4, 4 ); // return _xx_ of smwf_xx_methodname, may return FALSE
}

/**
 * Intializes Semantic NotifyMe Extension.
 * Called from SNM during initialization.
 */
function smwgNMSetupExtension() {
	global $smwgNMIP, $wgHooks, $wgJobClasses, $wgExtensionCredits;
	global $wgAutoloadClasses, $wgSpecialPages, $wgSpecialPageGroups;

	// register SMW hooks
	$wgHooks['smwInitializeTables'][] = 'smwfNMInitializeTables';

	$wgHooks['ArticleSaveComplete'][] = 'smwfNMSaveHook';
	$wgHooks['ArticleUndelete'][] = 'smwfNMUndeleteHook';
	$wgHooks['ArticleSave'][] = 'smwfNMPreSaveHook';
	$wgHooks['ArticleDelete'][] = 'smwfNMPreDeleteHook';

	// queryinterface hook
	$wgHooks['QI_AddButtons'][] = 'smwfNMAddQIButton';

	global $wgRequest, $wgContLang;

	$spns_text = $wgContLang->getNsText( NS_SPECIAL );

	// register AddHTMLHeader functions for special pages
	// to include javascript and css files (only on special page requests).
	if ( stripos( $wgRequest->getRequestURL(), $spns_text . ":" ) !== false
	|| stripos( $wgRequest->getRequestURL(), $spns_text . "%3A" ) !== false ) {

		if ( defined( 'SMW_HALO_VERSION' ) ) {
			// insert NM header hook before add halo header
			foreach ( $wgHooks['BeforePageDisplay'] as $k => $hookVal ) {
				if ( $hookVal == 'smwfHaloAddHTMLHeader' ) {
					$wgHooks['BeforePageDisplay'][$k] = 'smwNMAddHTMLHeader';
					break;
				}
			}
			$wgHooks['BeforePageDisplay'][] = 'smwfHaloAddHTMLHeader';
		} else {
			$wgHooks['BeforePageDisplay'][] = 'smwNMAddHTMLHeader';
		}

	}

	$wgJobClasses['SMW_NMSendMailJob'] = 'SMW_NMSendMailJob';
	require_once( $smwgNMIP . '/includes/jobs/SMW_NMSendMailJob.php' );
	$wgJobClasses['SMWNMRefreshJob'] = 'SMWNMRefreshJob';
	require_once( $smwgNMIP . '/includes/jobs/SMW_NMRefreshJob.php' );

	if ( defined( 'SMW_VERSION' ) && strpos( SMW_VERSION, '1.5' ) == 0 ) {
		$wgAutoloadClasses['SMWNotifyProcessor'] = $smwgNMIP . '/includes/SMW_NotifyProcessor.smw15.php';
	} else {
		$wgAutoloadClasses['SMWNotifyProcessor'] = $smwgNMIP . '/includes/SMW_NotifyProcessor.php';
	}

	$action = $wgRequest->getVal( 'action' );
	// add some AJAX calls
	if ( $action == 'ajax' ) {
		$method_prefix = smwfNMGetAjaxMethodPrefix();

		// decide according to ajax method prefix which script(s) to import
		switch( $method_prefix ) {
			case '_nm_' :
				require_once( $smwgNMIP . '/specials/SMWNotifyMe/SMW_NotAjaxAccess.php' );
				break;
		}
	} else { // otherwise register special pages
		$wgAutoloadClasses['SMWNotifyMe'] = $smwgNMIP . '/specials/SMWNotifyMe/SMWNotifyMe.php';
		$wgSpecialPages['NotifyMe'] = 'SMWNotifyMe';
		$wgSpecialPageGroups['NotifyMe'] = 'smw_group';
	}

	// Register Credits
	$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Semantic&#160;NotifyMe&#160;Extension', 'version' => SMW_NM_VERSION,
			'author' => "Ning Hu, Justin Zhang, [http://smwforum.ontoprise.com/smwforum/index.php/Jesse_Wang Jesse Wang], sponsored by [http://projecthalo.com Project Halo], [http://www.vulcan.com Vulcan Inc.]",
			'url' => 'http://wiking.vulcan.com/dev',
			'description' => 'Notify wiki user with specified queries.' );

	return true;
}

function smwfNMGetJSLanguageScripts( &$pathlng, &$userpathlng ) {
	global $smwgNMIP, $wgLanguageCode, $smwgNMScriptPath, $wgUser;

	// content language file
	$lng = '/scripts/Language/SMW_NMLanguage';
	if ( !empty( $wgLanguageCode ) ) {
		$lng .= ucfirst( $wgLanguageCode ) . '.js';
		if ( file_exists( $smwgNMIP . $lng ) ) {
			$pathlng = $smwgNMScriptPath . $lng;
		} else {
			$pathlng = $smwgNMScriptPath . '/scripts/Language/SMW_NMLanguageEn.js';
		}
	} else {
		$pathlng = $smwgNMScriptPath . '/scripts/Language/SMW_NMLanguageEn.js';
	}

	// user language file
	$lng = '/scripts/Language/SMW_NMLanguage';
	if ( isset( $wgUser ) ) {
		$lng .= "User" . ucfirst( $wgUser->getGlobalPreference( 'language' ) ) . '.js';
		if ( file_exists( $smwgNMIP . $lng ) ) {
			$userpathlng = $smwgNMScriptPath . $lng;
		} else {
			$userpathlng = $smwgNMScriptPath . '/scripts/Language/SMW_NMLanguageUserEn.js';
		}
	} else {
		$userpathlng = $smwgNMScriptPath . '/scripts/Language/SMW_NMLanguageUserEn.js';
	}
}

// NotifyMe scripts callback
// includes necessary script and css files.
function smwNMAddHTMLHeader( &$out ) {
	global $wgTitle;
	if ( $wgTitle->getNamespace() != NS_SPECIAL ) return true;

	global $smwgNMScriptPath, $smwgScriptPath;
	smwfNMGetJSLanguageScripts( $pathlng, $userpathlng );

	if ( defined( 'SMW_HALO_VERSION' ) ) {
		global $smwgHaloScriptPath, $smwgDeployVersion;

		$jsm = SMWResourceManager::SINGLETON();

		$jsm->addScriptIf( $smwgHaloScriptPath .  '/scripts/prototype.js', "all", -1, NS_SPECIAL . ":NotifyMe" );
		$jsm->addScriptIf( $smwgHaloScriptPath .  '/scripts/Logger/smw_logger.js', "all", -1, NS_SPECIAL . ":NotifyMe" );
		$jsm->addScriptIf( $smwgScriptPath .  '/skins/SMW_tooltip.js', "all", -1, NS_SPECIAL . ":NotifyMe" );

		$jsm->addScriptIf( $smwgNMScriptPath . '/scripts/Language/SMW_NMLanguage.js', "all", -1, NS_SPECIAL . ":NotifyMe" );
		$jsm->addScriptIf( $pathlng, "all", -1, NS_SPECIAL . ":NotifyMe" );
		$jsm->addScriptIf( $userpathlng, "all", -1, NS_SPECIAL . ":NotifyMe" );
		$jsm->addScriptIf( $smwgNMScriptPath .  '/scripts/NotifyMe/NotifyHelper.js', "all", -1, NS_SPECIAL . ":NotifyMe" );

		$jsm->addScriptIf( $smwgNMScriptPath . '/scripts/Language/SMW_NMLanguage.js', "all", -1, NS_SPECIAL . ":QueryInterface" );
		$jsm->addScriptIf( $pathlng, "all", -1, NS_SPECIAL . ":QueryInterface" );
		$jsm->addScriptIf( $userpathlng, "all", -1, NS_SPECIAL . ":QueryInterface" );
		$jsm->addScriptIf( $smwgNMScriptPath .  '/scripts/NotifyMe/NotifyHelper.js', "all", -1, NS_SPECIAL . ":QueryInterface" );

		$jsm->addCSSIf( $smwgScriptPath .  '/skins/SMW_custom.css', "all", -1, NS_SPECIAL . ":NotifyMe" );
		$jsm->addCSSIf( $smwgNMScriptPath . '/skins/nm.css', "all", -1, NS_SPECIAL . ":NotifyMe" );
	} else {
		global $wgRequest;
		$scripts = array();
		$$css = array();

		// read state
		if ( $wgRequest != NULL && $wgTitle != NULL ) {
			$action = $wgRequest->getVal( "action" );
			// $action of NULL or '' means view mode
			$action = $action == NULL || $action == '' ? "view" : $action;
			$namespace = $wgTitle->getNamespace();
			$page = $wgTitle->getNamespace() . ":" . $wgTitle->getText();

		} else { // if no state could be read, set default -> load all!
			$action = "all";
			$namespace = -1;
			$page = array();
		}
		if ( ( $namespace == NS_SPECIAL || $namespace == -1 ) && ( $page == NS_SPECIAL . ":NotifyMe" ) ) {
			$out->addScript( '<script type="text/javascript" src="' . $smwgNMScriptPath . '/scripts/prototype.js"></script>' );
			$out->addScript( '<script type="text/javascript" src="' . $smwgScriptPath . '/skins/SMW_tooltip.js"></script>' );
			$out->addScript( '<script type="text/javascript" src="' . $smwgNMScriptPath . '/scripts/Language/SMW_NMLanguage.js"></script>' );
			$out->addScript( '<script type="text/javascript" src="' . $pathlng . '"></script>' );
			$out->addScript( '<script type="text/javascript" src="' . $userpathlng . '"></script>' );
			$out->addScript( '<script type="text/javascript" src="' . $smwgNMScriptPath . '/scripts/NotifyMe/NotifyHelper.js"></script>' );

			$out->addLink( array(
					'rel'   => 'stylesheet',
					'type'  => 'text/css',
					'media' => 'screen, projection',
					'href'  => $smwgScriptPath . '/skins/SMW_custom.css'
					) );
					$out->addLink( array(
					'rel'   => 'stylesheet',
					'type'  => 'text/css',
					'media' => 'screen, projection',
					'href'  => $smwgNMScriptPath . '/skins/nm.css'
					) );
		}
	}
	return true; // do not load other scripts or CSS
}


function smwfNMPreSaveHook( &$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags ) {
	SMWNotifyProcessor::prepareArticleSave( $article->getTitle() );

	return true;
}
function smwfNMPreDeleteHook( &$article, &$user, &$reason ) {
	SMWNotifyProcessor::articleDelete( $article->getTitle(), $reason );

	return true;
}
function smwfNMSaveHook( &$article, &$user ) {
	SMWNotifyProcessor::articleSavedComplete( $article->getTitle() );

	return true; // always return true, in order not to stop MW's hook processing!
}
function smwfNMUndeleteHook( &$title, $create ) {
	SMWNotifyProcessor::articleSavedComplete( $title );
	return true; // always return true, in order not to stop MW's hook processing!
}
function smwfNMAddQIButton( &$buttons ) {
	global $wgUser;
	$user_id = $wgUser->getId();
	$buttons = '';
	if ( $user_id != 0 ) {
		$buttons = '<button class="btn" onclick="notifyhelper.saveQueryToNotify()" onmouseover="this.className=\'btn btnhov\'; Tip(\'' . wfMsg( 'smw_qi_tt_addNotify' ) . '\')" onmouseout="this.className=\'btn\'">' . wfMsg( 'smw_qi_addNotify' ) . '</button>';
	}
	return true;
}
