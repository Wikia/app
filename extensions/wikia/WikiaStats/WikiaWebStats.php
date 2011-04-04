<?php
if(!defined('MEDIAWIKI')) {
    exit( 1 ) ;
}

$extensions_dir = dirname(dirname(__FILE__));

require_once("$extensions_dir/WikiaUUID/WikiaUUID.php");

$wgHooks['SkinAfterBottomScripts'][] = 'wfWikiaWebStatsScript';
$wgHooks['MakeGlobalVariablesScript'][] = 'wfAddOneDotGlobals';

function getOneDotURL () {
	global $wgCityId, $wgContLanguageCode, $wgDBname, $wgDBcluster, $wgUser, $wgArticle, $wgTitle, $wgAdServerTest;
	global $wgOneDotURL;

	if ($wgOneDotURL) {
		return $wgOneDotURL;
	} else {
		$wgOneDotURL = '/__onedot?'.
							'c='.$wgCityId.'&'.
							'lc='.$wgContLanguageCode.'&'.
							'lid='.WikiFactory::LangCodeToId($wgContLanguageCode).'&'.
							'x='.$wgDBname.'&'.
							'y='.$wgDBcluster.'&'.
							'u='.$wgUser->getID().'&'.
							'a='.(is_object($wgArticle) ? $wgArticle->getID() : null).'&'.
							'n='.$wgTitle->getNamespace().
							(!empty($wgAdServerTest) ? '&db_test=1' : '');
	}
	
	return $wgOneDotURL;
}

function wfAddOneDotGlobals ($vars) {
	$vars['wgOneDotURL']    = getOneDotURL();
	$vars['wgOneDotCookie'] = WikiaUUID::cookieName();

	return true;
}

function wfWikiaWebStatsScript($this, $bottomScriptText) {
	global $wgCityId, $wgDotDisplay, $wgReadOnly, $wgJsMimeType, $wgStyleVersion, $wgExtensionsPath, $wgOut;

	if ( !empty($wgCityId) && !empty($wgDotDisplay) && empty($wgReadOnly) ) {
		$url = getOneDotURL();

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/WikiaStats/js/WikiaStats.js?$wgStyleVersion\"></script>\n" );

		$bottomScriptText .= '<script type="text/javascript">/*<![CDATA[*/OneDot.track()/*]]>*/</script>';
		$bottomScriptText .= '<noscript><img src="'.$url.'" width="1" height="1" border="0" alt="" /></noscript>';
		$bottomScriptText .= "\n";
	}
	return true;
}
