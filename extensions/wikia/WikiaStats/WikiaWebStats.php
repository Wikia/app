<?php
if(!defined('MEDIAWIKI')) {
    exit( 1 ) ;
}

$extensions_dir = dirname(dirname(__FILE__));

$wgHooks['SkinAfterBottomScripts'][] = 'wfWikiaWebStatsScript';

function wfWikiaWebStatsScript($this, $bottomScriptText) {
	global $wgCityId, $wgDotDisplay, $wgReadOnly;

	if ( !empty($wgCityId) && !empty($wgDotDisplay) && empty($wgReadOnly) ) {
		$url = getOneDotURL();

		$bottomScriptText .= "<script type=\"text/javascript\" src=\"$url\"></script>";
		$bottomScriptText .= '<noscript><img src="'.$url.'" width="1" height="1" border="0" alt="" /></noscript>';
		$bottomScriptText .= "\n";
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
