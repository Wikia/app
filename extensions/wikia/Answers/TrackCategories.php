<?php
/**
 * Track Categories Extension - Track page views by category
 *
 * @author Przemek Piotrowski (Nef) <ppiotr@wikia-inc.com>
 */

if (!defined("MEDIAWIKI")) {
	die("This file is an extension to the MediaWiki software and cannot be used standalone.");
}

$wgExtensionCredits["other"][] = array(
	"name"        => "TrackCategories",
	"author"      => "[http://www.wikia.com/wiki/User:Ppiotr Przemek Piotrowski (Nef)]",
	"description" => "Track page views by category",
	"svn-date"    => '$LastChangedDate: 2010-06-07 12:06:34 +0000 (Mon, 07 Jun 2010) $',
	"svn-revision" => '$LastChangedRevision: 22336 $',
);

$wgExtensionFunctions[] = 'wfTrackCategoriesSetup';

function wfTrackCategoriesSetup() {
	global $wgHooks;

	$wgHooks["SkinAfterBottomScripts"][] = "wfTrackCategoriesHook";
}

function wfTrackCategoriesHook($skin, &$text) {
	global $wgTitle;

	if (NS_MAIN == $wgTitle->getNamespace()) {
		$text .= "<script type=\"text/javascript\">/*<![CDATA[*/
			var trackCategoriesRemove = wgArticlePath.replace(\"\$1\", encodeURIComponent(wgCategoryName)).length + 1;
			$('#mw-normal-catlinks > span > a, #mw-hidden-catlinks > span > a').each(function (e) {
				WET.byStr('catview/' + $(this).attr('href').substring(trackCategoriesRemove));
			});
		/*]]>*/</script>\n";
	}

	return true;
}
