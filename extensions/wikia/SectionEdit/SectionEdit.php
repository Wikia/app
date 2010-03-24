<?php
/**
 * Adds green "edit" section buttons for anons
 *
 * @author Christian Williams <christian@wikia-inc.com>
 * @author Maciej Brencz <macbre@wikia-inc.com> - small fixes and enhancements
 */
$wgExtensionCredits['other'][] = array(
	'name' => 'SectionEdit',
	'description' => 'Adds green section edit buttons',
	'version' => '1.11',
	'author' => array('Christian Williams', 'Maciej Brencz')
);

$wgHooks['SpecialFooterAfterWikia'][] = 'SectionEditJS';

function SectionEditJS() {
	global $wgUser, $wgTitle, $wgJsMimeType;

	// add JS only for anons
	if (is_object($wgUser) && $wgUser->isLoggedIn()) {
		return true;
	}

	// don't add JS for protected pages and special pages (inherently protected)
	if ( $wgTitle->isProtected( 'edit' ) ) {
		return true;
	}

	// RT #10623: add green buttons also when anon editing is disabled
	if (is_object($wgUser) && (!$wgUser->isLoggedIn()) && (!$wgUser->isAllowed('edit'))) {
		$editMsg = Xml::escapeJsString(wfMsg('editsection'));
		$editUrl = Xml::escapeJsString($wgTitle->getEditUrl());

		$script = '
if (skin == "monaco") {
	$("h2 span.mw-headline").each(function(i) {
		//add elements and styling
		$(this).parent().prepend("<span class=\"editsection\"><a href=\"'.$editUrl.'\" onclick=\"WET.byStr(\'articleAction/editSection\')\">'.$editMsg.'</a></span>").find(".editsection a").addClass("wikia-button").end().parent().css("position", "relative").css("top", "-3px").css("margin-bottom", "-2px");
	});
}';
	}
	else {
		$script = '
if (skin == "monaco") {
	$("h2 span.editsection").each(function(i) {
		var link = $(this).children("a");
		//remove nodes in the editsection that are not anchors
		$(this).contents().not(link).remove();
		//add elements and styling
		link.addClass("wikia-button").end().parent().css("position", "relative").css("top", "-3px").css("margin-bottom", "-2px");
	});
}';
	}

	echo "<script type=\"$wgJsMimeType\">/*<![CDATA[*/$script\n/*]]>*/</script>";
	return true;
}
