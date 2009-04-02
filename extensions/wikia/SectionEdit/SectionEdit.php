<?
/**
 * Adds green "edit" section buttons for anons
 *
 * @author Christian Williams <christian@wikia-inc.com>
 */

$wgHooks['SpecialFooterAfterWikia'][] = 'SectionEditStyle';

function SectionEditStyle() {
	global $wgUser;
	if (is_object($wgUser) && $wgUser->isLoggedIn() ){
		return true;
	}
	
	echo '
<script type="text/javascript">
if (skin == "monaco") {
	jQuery.noConflict();
	jQuery("h2 span.editsection").each(function(i) {
		//remove nodes in the editsection that are not anchors
		jQuery(this).contents().not("a").remove();
		//add elements and styling
		jQuery(this).find("a").addClass("bigButton").contents().wrap("<big></big>").end().append("<small></small>").parent().css("position", "relative").css("top", "-3px").css("margin-bottom", "-2px");
	});
}
</script>';
	return true;
}
