<?php
if(!defined('MEDIAWIKI')) {
    exit( 1 ) ;
}

$extensions_dir = dirname(dirname(__FILE__));

$wgHooks['SkinAfterBottomScripts'][] = 'wfWikiaWebStatsScript';
$wgHooks['MakeGlobalVariablesScript'][] = 'wfAddOneDotGlobals';

function wfWikiaWebStatsScript($this, $bottomScriptText) {
	global $wgEnableOneDotPlus;

	if ($wgEnableOneDotPlus) {
		ajaxOneDot($bottomScriptText);
	} else {
		imageOneDot($bottomScriptText);
	}
	return true;
}

function wfAddOneDotGlobals ($vars) {
	global $wgEnableOneDotPlus;

	if ($wgEnableOneDotPlus) {
		$vars['wgOneDotURL']    = getOneDotURL();
	}

	return true;
}

function getOneDotURL () {
	global $wgCityId, $wgContLanguageCode, $wgDBname, $wgDBcluster, $wgUser, $wgArticle, $wgTitle, $wgAdServerTest;
	global $wgOneDotURL;

	if ($wgOneDotURL) {
		return $wgOneDotURL;
	}
	else {
		$wgOneDotURL = 'http://a.wikia-beacon.com/__onedot?'.
			'c='.$wgCityId.'&'.
			'lc='.$wgContLanguageCode.'&'.
			'lid='.WikiFactory::LangCodeToId($wgContLanguageCode).'&'.
			'x='.$wgDBname.'&'.
			'y='.$wgDBcluster.'&'.
			'u='.$wgUser->getID().'&'.
			'a='.(is_object($wgArticle) ? $wgArticle->getID() : null).'&'.
			'n='.$wgTitle->getNamespace(). (!empty($wgAdServerTest) ? '&db_test=1' : '');
	}

	return $wgOneDotURL;
}

function ajaxOneDot (&$bottomScriptText) {
	global $wgCityId, $wgDotDisplay, $wgReadOnly, $wgJsMimeType, $wgStyleVersion, $wgExtensionsPath, $wgOut;

	if ( !empty($wgCityId) && !empty($wgDotDisplay) && empty($wgReadOnly) ) {
		$url = getOneDotURL();

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/WikiaStats/js/WikiaStats.js?$wgStyleVersion\"></script>\n" );

		$bottomScriptText .= '<script type="text/javascript">/*<![CDATA[*/OneDot.track()/*]]>*/</script>';
		$bottomScriptText .= '<noscript><img src="'.$url.'" width="1" height="1" border="0" alt="" /></noscript>';
		$bottomScriptText .= "\n";
	}
}

function imageOneDot (&$bottomScriptText) {
	global $wgUser, $wgArticle, $wgTitle, $wgCityId, $wgDBname, $wgDBcluster, $wgDotDisplay, $wgAdServerTest, $wgReadOnly, $wgContLanguageCode;

	if ( !empty($wgCityId) && !empty($wgDotDisplay) && empty($wgReadOnly) ) {
		$url = 'http://a.wikia-beacon.com/__onedot?c='.$wgCityId.'&amp;lc='.$wgContLanguageCode.'&amp;lid='.WikiFactory::LangCodeToId($wgContLanguageCode).'&amp;x='.$wgDBname.'&amp;y='.$wgDBcluster.'&amp;u='.$wgUser->getID().'&amp;a='.(is_object($wgArticle) ? $wgArticle->getID() : null).'&amp;n='.$wgTitle->getNamespace().(!empty($wgAdServerTest) ? '&amp;db_test=1' : '');
		$bottomScriptText .= '<script type="text/javascript">/*<![CDATA[*/document.write("<img src=\"'.$url.'"+((typeof document.referrer != "undefined") ? "&amp;r="+escape(document.referrer) : "")+"&amp;cb="+(new Date).valueOf()+"\" width=\"1\" height=\"1\" border=\"0\" alt=\"\" />");/*]]>*/</script><noscript><img src="'.$url.'" width="1" height="1" border="0" alt="" /></noscript>';
		$bottomScriptText .= "\n";
	}
	return true;
}
