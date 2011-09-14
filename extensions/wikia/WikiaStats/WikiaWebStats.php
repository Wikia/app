<?php
return;
if(!defined('MEDIAWIKI')) {
    exit( 1 ) ;
}

$extensions_dir = dirname(dirname(__FILE__));

$wgHooks['SkinAfterBottomScripts'][] = 'wfWikiaWebStatsScript';

function wfWikiaWebStatsScript($this, $bottomScriptText) {
	global $wgCityId, $wgDotDisplay, $wgReadOnly;

	if ( !empty($wgCityId) && !empty($wgDotDisplay) && empty($wgReadOnly) ) {
		$url = getOneDotURL();

		$bottomScriptText .= <<<SCRIPT
<script type="text/javascript">
	var oneDotURL = "$url" + ((typeof document.referrer != "undefined") ? "&amp;r=" + escape(document.referrer) : "") + "&amp;cb=" + (new Date).valueOf();
 	document.write('<'+'script type="text/javascript" src="' + oneDotURL + '"><'+'/script>');
</script>
<noscript><img src="$url" width="1" height="1" border="0" alt="" /></noscript>
SCRIPT;

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
