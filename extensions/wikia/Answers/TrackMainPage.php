<?php
/**
 * Track MainPage Extension - Track link clicks on MainPage
 *
 * @author Przemek Piotrowski (Nef) <ppiotr@wikia-inc.com>
 */

if (!defined("MEDIAWIKI")) {
	die("This file is an extension to the MediaWiki software and cannot be used standalone.");
}

$wgExtensionCredits["other"][] = array(
	"name"        => "TrackMainPage",
	"author"      => "[http://www.wikia.com/wiki/User:Ppiotr Przemek Piotrowski (Nef)]",
	"description" => "Track link clicks on MainPage",
	"svn-date"    => '$LastChangedDate: 2010-06-07 12:08:27 +0000 (Mon, 07 Jun 2010) $',
	"svn-revision" => '$LastChangedRevision: 22337 $',
);

$wgExtensionFunctions[] = 'wfTrackMainPageSetup';

function wfTrackMainPageSetup() {
	global $wgHooks;

	$wgHooks["SkinAfterBottomScripts"][] = "wfTrackMainPageHook";
}

function wfTrackMainPageHook($skin, &$text) {
	global $wgTitle, $wgRequest;

	if ((Title::newMainPage()->getArticleId() == $wgTitle->getArticleId()) && ("view" == $wgRequest->getVal("action", "view"))) {
		$text .= "<script type=\"text/javascript\">/*<![CDATA[*/
			var wgServerRE      = new RegExp('^' + wgServer.replace(/\\\\/, '\\\\'));
			var wgArticlePathRE = new RegExp('^' + wgArticlePath.replace(/\\$1/, '').replace(/\\\\/, '\\\\'));
			$('#bodyContent a[href]').each(function (e) {
				//$(this).css('background-color', 'yellow');
				if ($(this).parent().attr('class') == 'usermessage') {
					// skip 'you have new mesages on wiki foo' box
				} else {
					var tracker = $(this).attr('href').replace(wgServerRE, '').replace(wgArticlePathRE, '').replace(/[\\/?&]/g, '_');
					$(this).bind('click', function (e) { WET.byStr('mainpage/' + tracker); });
				}
			});
		/*]]>*/</script>\n";
	}

	return true;
}
