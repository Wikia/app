<?

$wgHooks['SpecialFooterAfterWikia'][] = 'SectionEditStyle';

function SectionEditStyle() {
	global $wgUser;
	if (is_object($wgUser) && $wgUser->isLoggedIn() ){
		return true;
	}
	
	echo '<script type="text/javascript">
	if (skin == "monaco") {
	var elements = YAHOO.util.Dom.getElementsByClassName("editsection");
	for (i=0; i<elements.length; i++) {
		//Move it
		sibling = YAHOO.util.Dom.getNextSibling(elements[i]);
		YAHOO.util.Dom.insertAfter(elements[i], sibling);
		//Style it
		YAHOO.util.Dom.addClass(elements[i], "color1");
		YAHOO.util.Dom.addClass(elements[i], "editsectionbutton");
	}
	}
	</script>';
	return true;
}
?>
