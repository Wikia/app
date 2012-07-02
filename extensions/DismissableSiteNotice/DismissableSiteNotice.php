<?php

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DismissableSiteNotice',
	'author' => 'Brion Vibber',
	'descriptionmsg' => 'sitenotice-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:DismissableSiteNotice',
);

$wgExtensionMessagesFiles['DismissableSiteNotice'] = dirname(__FILE__) . '/DismissableSiteNotice.i18n.php';

function wfDismissableSiteNotice( &$notice ) {
	global $wgMajorSiteNoticeID, $wgUser;

	if ( !$notice ) {
		return true;
	}

	$encNotice = Xml::escapeJsString($notice);
	$encClose = Xml::escapeJsString( wfMsg( 'sitenotice_close' ) );
	$id = intval( $wgMajorSiteNoticeID ) . "." . intval( wfMsgForContent( 'sitenotice_id' ) );

	// No dismissal for anons
	if ( $wgUser->isAnon() ) {
		$notice = <<<HTML
<script type="text/javascript">
/* <![CDATA[ */
document.writeln("$encNotice");
/* ]]> */
</script>
HTML;
		return true;
	}

	$notice = <<<HTML
<script type="text/javascript">
/* <![CDATA[ */
var cookieName = "dismissSiteNotice=";
var cookiePos = document.cookie.indexOf(cookieName);
var siteNoticeID = "$id";
var siteNoticeValue = "$encNotice";
var cookieValue = "";
var msgClose = "$encClose";

if (cookiePos > -1) {
	cookiePos = cookiePos + cookieName.length;
	var endPos = document.cookie.indexOf(";", cookiePos);
	if (endPos > -1) {
		cookieValue = document.cookie.substring(cookiePos, endPos);
	} else {
		cookieValue = document.cookie.substring(cookiePos);
	}
}
if (cookieValue != siteNoticeID) {
	function dismissNotice() {
		var date = new Date();
		date.setTime(date.getTime() + 30*86400*1000);
		document.cookie = cookieName + siteNoticeID + "; expires="+date.toGMTString() + "; path=/";
		var element = document.getElementById('mw-dismissable-notice');
		element.parentNode.removeChild(element);
	}
	document.writeln('<table width="100%" id="mw-dismissable-notice"><tr><td width="80%">'+siteNoticeValue+'</td>');
	document.writeln('<td width="20%" align="right">[<a href="javascript:dismissNotice();">'+msgClose+'</a>]</td></tr></table>');
}
/* ]]> */
</script>
HTML;
	// Compact the string a bit
	/*
	$notice = strtr( $notice, array(
		"\r\n" => '',
		"\n" => '',
		"\t" => '',
		'cookieName' => 'n',
		'cookiePos' => 'p',
		'siteNoticeID' => 'i',
		'siteNoticeValue' => 'sv',
		'cookieValue' => 'cv',
		'msgClose' => 'c',
		'endPos' => 'e',
	));*/
	return true;
}

$wgHooks['SiteNoticeAfter'][] = 'wfDismissableSiteNotice';

$wgMajorSiteNoticeID = 1;
