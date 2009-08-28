<?php

$wgHooks["MonacoAfterArticleLinks"][] = "efBolekButton";

function efBolekButton() {
	global $wgTitle;
	if (!$wgTitle->isContentPage() && !(NS_PROJECT == $wgTitle->getNamespace())) return true;

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

$wgHooks["Parser::FetchTemplateAndTitle"][] = "efBolekTemplate";

function efBolekTemplate($text, $finalTitle) {
	global $wgTitle;
	if (!$wgTitle->isContentPage() && !(NS_PROJECT == $wgTitle->getNamespace())) return true;

	$blacklist = array("Accuracy","ActiveDiscuss","Admin Needed","Adopted","Also","Ambox","Appearances Needs Work","Attention","Audio-da","Audio-de","Audio-es","Audio-ru","Audio2","AuditRequest","Beta","Bettername","Bginfo","Boilerplate","Buildinfo","CONTENTS","Canon","CatNeeded","Categories","Check","Citation","Cleancat","Cleanup","Cleanup-confusing","Cleanup-context","Cleanup-copyedit","Cleanup-icon","Cleanup-image","Cleanup-importance","Cleanup-rewrite","Comment","Concept art","Confirm","Constantedits","Construction","Contradict","Controversial","Copy Edit","Copyvio","Copyvioimage","Crop","Delete","Deleteagain","Deletecat","Deleted","Deletepage","Deletionimage","Deprecated","Deprecated template","Disambig","Disambig/achievement2","Disambig/item","Disambig/quest","Disambig/quest2","Disambig/server","Discontinuedlist","Dispute","Disputed","Distinguish","Doom","Doomed","Duplicate","Dynamic list","Elinks-vio","Eras","Essay","Expand","Expandsect","External links","FTBR","Fact","FactCheck","FactOK","Fair use","Fanart","Fanon","Featuredremoval","Future television","GAhelp","GIF to PNG","GM-item","Gacleanup","Galleryonly","HelpNeeded","HelpNeeded/Evil","HelpNeeded/Good","High-traffic","Holdon","Icon needed","Ifd","Image","Imagequality","Imr","InUse","Inactiveguild","Incite","Incomplete","Inuse","JPEG to PNG","Listdev","Listen","LivingPerson","Maforum","Merchandise","Merge","Merge From","Merge To","Merge with","Mergefrom","Mergeto","Merging","More sources","Move","Move2","Move3","Movecat","Movecat-decision","Multi-listen end","Multi-listen item","Multi-listen start","NDA","NPOV","NPOV-title","NYI","Naming","Newcategory","Notability","Notyetingame","Obsolete","Offtopic","Oid","Oou","Original research","Otheruses","Otheruses2","Out-of-universe","Outdated","Overhaul","Overpop","Oversized image","PNG to JPEG","PNGNowAvailable","Peerreview","Plot","Policy/Proposal","Popcat","PotentialVanity","Preview","Problem","Proseline","Protected","Protected-anon","QA Nom","Qlisten","Ratified","Recalled","Recat","Redirect","Redlink","Rejected","Removedfrombeta","Removedfromgame","Replace Image","Replaceimage","Resources","Reuploadsmaller","SIP","SVGNowAvailable","Screenshot","Semiprotected","Semiprotected2","ShouldBeSVG","Sign","Source needed","Speedydelete","Spelling","Split","StarCraft","Stub","Stub/API","Stub/Ability","Stub/Accuracy","Stub/Achievement","Stub/Admin","Stub/Blizzard","Stub/Box","Stub/Category","Stub/Char","Stub/Guild","Stub/Item","Stub/Location","Stub/Lore","Stub/Mob","Stub/NPC","Stub/Object","Stub/Other","Stub/PC","Stub/PTR","Stub/PTR-section","Stub/Player","Stub/Quest","Stub/Strategy","Stub/Talent","Stub/Tech","Stub/UI","Summary Needed","TCWRetcon","Templateimage","Tense","Terminate","Test","This","Threeconflicting","Tone","Trivia","Twoconflicting","Twoversions","Uc","Unusedimage","Update","Verify","Violation","Violation/Guild","Violation/PC","Warlock project","Wikify","Wikipedia","Wip","Wookify","Youmay","cleanup");

	if (in_array($finalTitle->getText(), $blacklist)) {
		// rt#21199 - table template *must* begin at col=1
		if ("{|" == substr($text, 0, 2)) {
			$text = "\n" . $text;
		}

		$text = "<div class=\"bolek-remove\" style=\"display: inline\">" . $text . "</div>";
	}

	return true;
}

