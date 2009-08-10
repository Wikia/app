<?php

$wgHooks["MonacoAfterArticleLinks"][] = "efBolekButton";

function efBolekButton() {
	global $wgTitle;
	if (NS_MAIN != $wgTitle->getNamespace()) return true;

	global $wgUser;
	if (!in_array($wgUser->getName(), array("Ppiotr", "Angies", "Shahid", "VickyBC", "Eloy.wikia"))) {
		return true;
	}

	$page_id = $wgTitle->getArticleId();
	echo "<li id=\"control_bolek\"><a href=\"/wiki/Special:Bolek?action=add&page_id={$page_id}\">Collect</a></li>";

	return true;
}

$dir = dirname(__FILE__);
extAddSpecialPage("$dir/SpecialBolek_body.php", "Bolek", "BolekPage");

include "$dir/Bolek_class.php";
include "$dir/Lolek_class.php";

