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
	'version' => '1.1',
	'author' => array('Christian Williams', 'Maciej Brencz')
);

$wgHooks['SpecialFooterAfterWikia'][] = 'SectionEditJS';

function SectionEditJS() {
	global $wgUser, $wgTitle, $wgDisableAnonymousEditig, $wgJsMimeType;

	// add JS only for anons
	if (is_object($wgUser) && $wgUser->isLoggedIn()) {
		return true;
	}

	// RT #10623: add green buttons also when anon editing is disabled
	if ( !empty($wgDisableAnonymousEditig)) {
		$editMsg = Xml::escapeJsString(wfMsg('editsection'));
		$editUrl = Xml::escapeJsString($wgTitle->getEditUrl());

		$script = '
if (skin == "monaco") {
	jQuery.noConflict();
	jQuery("h2 span.mw-headline").each(function(i) {
		//add elements and styling
		jQuery(this).parent().prepend("<span class=\"editsection\"><a href=\"'.$editUrl.'\">'.$editMsg.'</a></span>").find("a").addClass("bigButton").contents().wrap("<big></big>").end().append("<small></small>").parent().css("position", "relative").css("top", "-3px").css("margin-bottom", "-2px");
	});
}';
	}
	else {
		$script = '
if (skin == "monaco") {
	jQuery.noConflict();
	jQuery("h2 span.editsection").each(function(i) {
		//remove nodes in the editsection that are not anchors
		jQuery(this).contents().not("a").remove();
		//add elements and styling
		jQuery(this).find("a").addClass("bigButton").contents().wrap("<big></big>").end().append("<small></small>").parent().css("position", "relative").css("top", "-3px").css("margin-bottom", "-2px");
	});
}';
	}

	echo "<script type=\"$wgJsMimeType\">/*<![CDATA[*/$script\n/*]]>*/</script>";
	return true;
}
