<?php
/*
 * Created on 01.09.2009
 *
 * Author: Ning
 */
if ( !defined( 'MEDIAWIKI' ) ) die;

define( 'SMW_EXTTAB_VERSION', '1.0.0 alpha' );

$smwgExtTabIP = $IP . '/extensions/ExtTab';
$smwgExtTabScriptPath = $wgScriptPath . '/extensions/ExtTab';
$smwgExtTabEnabled = true;

global $wgExtensionFunctions, $wgHooks, $wgAutoloadClasses, $smwgExtTabEnableLocalEdit;
$wgExtensionFunctions[] = 'smwgExtTabSetupExtension';

$wgExtensionMessagesFiles['ExtTabMagic'] = $smwgExtTabIP . '/languages/ExtTab.i18n.magic.php';
$wgAutoloadClasses['ETParserFunctions'] = $smwgExtTabIP . '/includes/ET_ParserFunctions.php';

function smwfExtTabGetAjaxMethodPrefix() {
	$func_name = isset( $_POST["rs"] ) ? $_POST["rs"] : ( isset( $_GET["rs"] ) ? $_GET["rs"] : NULL );
	if ( $func_name == NULL ) return NULL;
	return substr( $func_name, 4, 4 ); // return _xx_ of smwf_xx_methodname, may return FALSE
}

/**
 * Intializes Semantic ExtTab Extension.
 * Called from ET during initialization.
 */
function smwgExtTabSetupExtension() {
	global $smwgExtTabIP, $wgExtensionCredits;
	global $wgParser, $wgHooks, $wgAutoloadClasses;

	// register hooks
	if ( defined( 'MW_SETPORTS_PARSERFIRSTCALLINIT' ) ) {
		$wgHooks['ParserFirstCallInit'][] = 'ETParserFunctions::registerFunctions';
	} else {
		if ( class_exists( 'StubObject' ) && !StubObject::isRealObject( $wgParser ) ) {
			$wgParser->_unstub();
		}
		ETParserFunctions::registerFunctions( $wgParser );
	}

	global $wgRequest;

	$action = $wgRequest->getVal( 'action' );
	// add some AJAX calls
	if ( $action == 'ajax' ) {
		$method_prefix = smwfExtTabGetAjaxMethodPrefix();

		// decide according to ajax method prefix which script(s) to import
		switch( $method_prefix ) {
			case '_et_' :
				require_once( $smwgExtTabIP . '/includes/ET_AjaxAccess.php' );
				break;
		}
	}

	// Register Credits
	$wgExtensionCredits['parserhook'][] = array(
		'name' => 'Semantic&nbsp;ExtTab&nbsp;Extension', 'version' => SMW_EXTTAB_VERSION,
		'author' => "Ning Hu, Justin Zhang, [http://smwforum.ontoprise.com/smwforum/index.php/Jesse_Wang Jesse Wang], sponsored by [http://projecthalo.com Project Halo], [http://www.vulcan.com Vulcan Inc.]",
		'url' => 'http://wiking.vulcan.com/dev',
		'description' => 'Tab control based on ExtJS.',
	);

	return true;
}

function smwfExtTabGetJSLanguageScripts( &$pathlng, &$userpathlng ) {
	global $smwgExtTabIP, $wgLanguageCode, $smwgExtTabScriptPath, $wgUser;

	// content language file
	$lng = '/scripts/Language/ET_Language';
	if ( !empty( $wgLanguageCode ) ) {
		$lng .= ucfirst( $wgLanguageCode ) . '.js';
		if ( file_exists( $smwgExtTabIP . $lng ) ) {
			$pathlng = $smwgExtTabScriptPath . $lng;
		} else {
			$pathlng = $smwgExtTabScriptPath . '/scripts/Language/ET_LanguageEn.js';
		}
	} else {
		$pathlng = $smwgExtTabScriptPath . '/scripts/Language/ET_LanguageEn.js';
	}

	// user language file
	$lng = '/scripts/Language/ET_Language';
	if ( isset( $wgUser ) ) {
		$lng .= "User" . ucfirst( $wgUser->getOption( 'language' ) ) . '.js';
		if ( file_exists( $smwgExtTabIP . $lng ) ) {
			$userpathlng = $smwgExtTabScriptPath . $lng;
		} else {
			$userpathlng = $smwgExtTabScriptPath . '/scripts/Language/ET_LanguageUserEn.js';
		}
	} else {
		$userpathlng = $smwgExtTabScriptPath . '/scripts/Language/ET_LanguageUserEn.js';
	}
}

?>