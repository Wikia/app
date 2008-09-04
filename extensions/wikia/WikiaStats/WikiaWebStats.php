<?php
if(!defined('MEDIAWIKI')) {
    exit( 1 ) ;
}

$wgHooks['SkinAfterBottomScripts'][] = 'wfWikiaWebStatsScript';

function wfWikiaWebStatsScript($this, $bottomScriptText) {
	global $wgUser, $wgArticle, $wgTitle, $wgCityId, $wgDotDisplay, $wgAdServerTest;
	if(!empty($wgCityId) && !empty($wgDotDisplay)) {
		$url = 'http://wikia-ads.wikia.com/onedot.php?c='.$wgCityId.'&amp;u='.$wgUser->getID().'&amp;a='.(is_object($wgArticle) ? $wgArticle->getID() : null).'&amp;n='.$wgTitle->getNamespace().(!empty($wgAdServerTest) ? '&amp;db_test=1' : '');
		$bottomScriptText .= '<script type="text/javascript">/*<![CDATA[*/document.write("<img src=\"'.$url.'"+((typeof document.referrer != "undefined") ? "&amp;r="+escape(document.referrer) : "")+"&amp;cb="+(new Date).valueOf()+"\" width=\"1\" height=\"1\" border=\"0\" alt=\"\" />");/*]]>*/</script><noscript><img src="'.$url.'" width="1" height="1" border="0" alt="" /></noscript>';
	}
	return true;
}
