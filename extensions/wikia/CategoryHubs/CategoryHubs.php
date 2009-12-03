<?php
////
// Author: Sean Colombo
// Date: 20091119
//
// This extension seeks to turn category pages into a hub of activity centered around that category.
// The goal is to make it easy for contributors to use this page to quickly see what's going on and act
// on the answered/unanswered questions.
//
// This extension depends on the FlexibleCategoryViewer extension.
// This extension depends on the CategoryStats extension.
// This extension depends on the Answer class.
//
// TODO: MAKE SURE THE USERBADGES STILL LOOK THE SAME ON ALL PAGES.  IT SEEMS THAT THE TOP MARGIN ON THE USERINFO MIGHT HAVE CHANGED IN ITS ORIGINAL USAGE (ALTHOUGH IT SEEMS TO RENDER FINE IN MY NEW USAGE... CACHING??).
// TODO: MAKE SURE THE PAGINATION LINKS SHOW UP IN THE RIGHT SPOT.  Category:Pokemon SHOULD BE HELPFUL FOR TESTING. They used to be in getCategoryBottom, but currently we're just not showing that section (probably want to override it in the future instead).
////

if ( ! defined( 'MEDIAWIKI' ) ){
	die("Extension file.  Not a valid entry point");
}

define('CATHUB_NORICHCATEGORY', 'CATHUB_NORICHCATEGORY');
define('CATHUB_RECENT_CONTRIBS_LOOKBACK_DAYS', 7);
define('ANSWERED_CATEGORY', 'answered_questions'); // must be set to the name of the category containing answered questions.

///// BEGIN - SETUP HOOKS /////
$wgHooks['LanguageGetMagic'][] = 'categoryHubAddMagicWords'; // setup names for parser functions (needed here)
$wgHooks['ParserAfterStrip'][] = 'categoryHubCheckForMagicWords';

// Allows us to define a special order for the various sections on the page.
$wgHooks['FlexibleCategoryPage::openShowCategory'][] = 'categoryHubBeforeArticleText';
$wgHooks['FlexibleCategoryPage::closeShowCategory'][] = 'categoryHubAfterArticleText';

// Override the appearance of the sections on the category page.
$wgHooks['FlexibleCategoryViewer::getCategoryTop'][] = 'categoryHubCategoryTop';
//$wgHooks['FlexibleCategoryViewer::getOtherSection'][] = 'categoryHubOtherSection';
$wgHooks['FlexibleCategoryViewer::getSubcategorySection'][] = 'categoryHubSubcategorySection';

$wgExtensionMessagesFiles['CategoryHub'] = dirname(__FILE__).'/CategoryHubs.i18n.php';
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CategoryHub',
	//'description' => '',
	'descriptionmsg' => 'cathub-desc',
	'author' => '[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]',
	'version' => '0.1',
);
///// END - SETUP HOOKS /////


global $wgCatHub_useDefaultView;
if(!isset($wgCatHub_useDefaultView)){
	$wgCatHub_useDefaultView = false;
}

////
// Used to add the __NORICHCATEGORY__ behavior switch (magic word).
// Bound to $wgHooks['LanguageGetMagic'][]
////
function categoryHubAddMagicWords(&$magicWords, $langCode){
	$magicWords[CATHUB_NORICHCATEGORY] = array( 0, '__NORICHCATEGORY__' );
	return true;
}

////
// Determines if the magic word is present for disabling the Category Hub and defaulting to previous behavior.
////
function categoryHubCheckForMagicWords(&$parser, &$text, &$strip_state) {
	global $wgCatHub_useDefaultView;
	if((!isset($wgCatHub_useDefaultView)) || (!$wgCatHub_useDefaultView)){
		$mw = MagicWord::get(CATHUB_NORICHCATEGORY);
		$wgCatHub_useDefaultView = $mw->matchAndRemove($text); // removes the token... don't look for it again after this
	} else if(isset($wgCatHub_useDefaultView) && $wgCatHub_useDefaultView){
		$mw = MagicWord::get(CATHUB_NORICHCATEGORY);
		$text = preg_replace($mw->getRegex(), '', $text);
	}
	return true;
}



///// THE NEXT TWO FUNCTIONS LET US OVERRIDE THE ORDER OF THE SECTIONS ON THE CATEGORY PAGE /////

////
// Overrides FlexibleCategoryPage::openShowCategory to allow us to choose which sections to display
// before the category's article text.
////
function categoryHubBeforeArticleText(&$flexibleCategoryPage){
	global $wgCatHub_useDefaultView;
	wfLoadExtensionMessages('CategoryHub');

	// Since this is executed before the parser gets called (and thus the hooks), must also check for the magic word here (unless it was already found elsewhere).
	if((!isset($wgCatHub_useDefaultView)) || (!$wgCatHub_useDefaultView)){
		$mw = MagicWord::get(CATHUB_NORICHCATEGORY);
		$wgCatHub_useDefaultView = (0 < $mw->match($flexibleCategoryPage->getRawText())); // match does not return bool as documented. fix is committed to MediaWiki svn.
	}

	if(!$wgCatHub_useDefaultView){
		global $wgOut;
		$r = "";
		// Using these default functions (and then hooking into them) instead of local functions makes the viewer initialization automatic.
		$r .= $flexibleCategoryPage->flexibleViewer->getCategoryTop();
		$r .= $flexibleCategoryPage->flexibleViewer->getOtherSection();
		//$r .= $flexibleCategoryPage->flexibleViewer->getPagesSection();
		//$r .= $flexibleCategoryPage->flexibleViewer->getImageSection();
		$wgOut->addHTML($r);
	}

	return $wgCatHub_useDefaultView;
} // end categoryHubOpenBeforeArticleText()

////
// Overrides FlexibleCategoryPage::closeShowCategory to allow us to choose which sections to display
// after the category's article text.
////
function categoryHubAfterArticleText(&$flexibleCategoryPage){
	global $wgCatHub_useDefaultView;
	wfLoadExtensionMessages('CategoryHub');

	if(!$wgCatHub_useDefaultView){
		global $wgOut;
		$r = "";
		// Using these default functions (and then hooking into them) instead of local functions makes the viewer initialization automatic.
		$r .= $flexibleCategoryPage->flexibleViewer->getSubcategorySection();
		//$r .= $flexibleCategoryPage->flexibleViewer->getCategoryBottom(); // default behavior displays pagination links which we don't want... and we don't attach to this hook yet.
		$wgOut->addHTML($r);
	}

	return $wgCatHub_useDefaultView;
} // end categoryHubAfterArticleText()


///// THE SECTIONS BELOW MODIFY THE APPEARANCE OF EACH SECTION /////


////
// Returns the HTML for the top of the category hub page.  This includes our modified title bar and
// the Top Contributors section.
////
function categoryHubCategoryTop(&$catView, &$r){
	global $wgCatHub_useDefaultView;
	if(!$wgCatHub_useDefaultView){
		categoryHubTitleBar($catView, $r);
		categoryHubTopContributors($catView, $r);
	}
	return $wgCatHub_useDefaultView;
} // end categoryHubCategoryTop()

////
// Displays the custom title bar (replaces the normal title) this includes the icon of the associated
// wiki (if applicable),  the title, progress bar or how many are answered, and the notification button.
////
function categoryHubTitleBar(&$catView, &$r){
	// Hide the normal title and add any other CategoryHub specific CSS.
	// Most of the CSS for CategoryHubs is in Answers' main.css.  This just contains things that we either don't want on every page (the h1.firstHeading hiding) or need to compute in here (background images).
	GLOBAL $wgScriptPath;
	$r .= "<style type='text/css'>
	h1.firstHeading { display:none; }
	#cathub-title-bar{
		background-image:url($wgScriptPath/extensions/wikia/CategoryHubs/cat_hub_title_bg.png);
	}
	.cathub-progbar-wrapper{
		background-image:url($wgScriptPath/extensions/wikia/CategoryHubs/prog_bar_endcap.png);
	}
	.cathub-progbar-answered{
		background-image:url($wgScriptPath/extensions/wikia/CategoryHubs/prog_bar_answered.png);
	}
	.cathub-progbar-unanswered{
		background-image:url($wgScriptPath/extensions/wikia/CategoryHubs/prog_bar_unanswered.png);
	}
	</style>";

	// Build up the title bar by its various pieces
	$r .= "<div id='cathub-title-bar'>\n";

	// Fetch the icon for the corresponding wiki if there is one.
WikiFactory::isUsed(true); // TODO: REMOVE - ONLY NEEDED FOR LOCAL TESTING!
	$logoSrc = WikiFactory::getVarValueByName( "wgLogo", WikiFactory::DomainToId( $catView->getCat()->getName().".wikia.com"));
	if($logoSrc != ""){
		$r .= "<img src='$logoSrc' width='78' height='78' style='float:left;padding:5px;'/>";
	}

	// Button for being notified of any new questions tagged with this category.
	// TODO: IMPLEMENT BACKEND FOR TRACKING NOTIFICATIONS
	// TODO: IMPLEMENT THE EXTENSION CODE FOR SENDING OUT NOTIFICATIONS WHEN A NEW CATEGORIZATION IS ADDED
	// TODO: IMPLEMENT THE AJAX FOR CLICKING THIS BUTTON
	// TODO: IMPLEMENT THE NEW APPEARANCE OF THIS BUTTON FOR A USER WHO IS ALREADY FOLLOWING THIS CATEGORY
	// TODO: GET THE CORRECT ARTWORK FOR BOTH THE ALREADY-NOTIFIED AND UN-NOTIFIED STATES OF THE BUTTON
	$r .= " <img id='cathub-notify-me' src='./images/TEMP_NOTIFY_ICON.jpg' width='64' height='64' style='float:right;padding:5px;'/>";

	// The actual title that will show up (since we hide the default).
	$r .= "<h1>".$catView->getCat()->getTitle()."</h1>";

	$PROG_BAR_WIDTH = 250; // in pixels.  If this is changed, make sure to re-evaluate MIN_PERCENT_TO_SHOW_TEXT_ON_LEFT
	$MIN_PERCENT_TO_SHOW_TEXT = 11; // if cat is this percentage or more complete, the percentage will be shown in left side of progress bar.
	$MIN_PERCENT_TO_ADD_SPACE = 14; // adds a second non-breaking space before % answered if there is room for it (to make it look better).
	$categoryEdits = CategoryEdits::newFromId($catView->getCat()->getId());
	$r .= "<div style='display:table;width:$PROG_BAR_WIDTH"."px'>"; // wraps the progress bar and the labels below it
	$r .= "<div class='cathub-progbar-wrapper' style='width:$PROG_BAR_WIDTH"."px'>";
	$percentAnswered = $categoryEdits->getPercent(ANSWERED_CATEGORY);
	if($percentAnswered <= 0){
		$percentAnswered = 0;
		$r .= "<div class='cathub-progbar-unanswered' style='width:$PROG_BAR_WIDTH'>No questions answered yet</div>\n";
	} else if($percentAnswered >= 100){
		$percentAnswered = 100;
		$r .= "<div class='cathub-progbar-answered' style='width:$PROG_BAR_WIDTH' title=''>All questions answered!</div>\n";
	} else {
		// TODO: EXTRACT THIS TO A FUNCTION WHICH WILL MAKE A BANDWIDTH-EFFICIENT PROGRESS BAR FOR ANY USE (IF POSSIBLE TO DO CLEANLY... MIGHT HAVE TO REQUIRE IT TO BE ANSWERS-SPECIFIC).
		$aPercent = substr($percentAnswered, 0, -1); // removes the "%" sign
		$uPercent = (100 - $aPercent);
		$aWidth = round(($PROG_BAR_WIDTH * $aPercent) / 100);
		$uWidth = $PROG_BAR_WIDTH - $aWidth;
		$aTitle = "$percentAnswered answered"; // TODO: USE MESSAGES FOR answered / not answered
		$uTitle = "$uPercent% not answered yet";

		// Heuristic to figure out which side to put the text on (prefering to put it on the left whenever possible since it is more intuitive
		// to see the percent done rather than not done).  Since users have various font-sizes, this is meant to give a sizable leeway.
		$aText = $uText = "&nbsp;";
		if($aPercent >= $MIN_PERCENT_TO_ADD_SPACE){
			$aText .= "&nbsp;";
		}
		if($aPercent < $MIN_PERCENT_TO_SHOW_TEXT){ // if possible, be less confusing by leaving the number on the left.
			$aText = "&nbsp;";
			$uText = "&nbsp;";
		} else if($uPercent < $MIN_PERCENT_TO_SHOW_TEXT){
			$aText .= round($aPercent)."%";
			$uText = "&nbsp;";
		} else {
			$aText .= round($aPercent)."%";
			$uText = round($uPercent)."%&nbsp;&nbsp;";
		}

		$r .= "<div class='cathub-progbar cathub-progbar-answered' style='width:$aWidth"."px' title='$aTitle'>$aText</div>";
		$r .= "<div class='cathub-progbar cathub-progbar-unanswered' style='width:$uWidth"."px' title='$uTitle'>$uText</div>";
	}
	$r .= "</div>"; // close the wrapper on the progress bar

	$r .= "<div class='cathub-progbar-label cathub-progbar-label-left'>Answered</div><div class='cathub-progbar-label cathub-progbar-label-right'>Unanswered</div>";
	$r .= "</div>"; // close the wrapper on the div containing the progress bar and the labels.

	$r .= "</div>\n";
} // end categoryHubTitleBar()

////
// Appends the top contributors of all time for this category as well as the top contributors
// in the last X days (X == 7 initially, this may change) to the value of r.
////
function categoryHubTopContributors(&$catView, &$r){
	$r .= "<div id='topContributorsWrapper'>\n";
	$r .= "<h2>".wfMsgExt('cathub-top-contributors', array())."</h2>";

	$categoryEdits = CategoryEdits::newFromId($catView->getCat()->getId());
	$NUM_CONTRIBS_PER_SECTION = 10;

	// Top Contributors for all time
	$r .= "<div id='topContribsAllTime'>\n";
	$r .= "<h3>".wfMsgExt('cathub-top-contribs-all-time', array())."</h3>";
	$r .= categoryHubContributorsToHtml($categoryEdits->getContribs($NUM_CONTRIBS_PER_SECTION));
	$r .= "</div>\n";

	// Recent Top Contributors
	$r .= "<div id='topContribsRecent'>\n";
	$r .= "<h3>".wfMsgExt('cathub-top-contribs-recent', array(), CATHUB_RECENT_CONTRIBS_LOOKBACK_DAYS)."</h3>";
	$r .= categoryHubContributorsToHtml($categoryEdits->getXDayContribs($NUM_CONTRIBS_PER_SECTION));
	$r .= "</div>\n";

	$r .= "</div><div style='clear:both'>&nbsp;</div>\n"; // clearing div is for Chrome
} // end categoryHubTopContributors()

////
// Given an array of user ids mapped to and how many edits they've had in the valid lookback period for this category,
// (as returned from CategoryEdits::getContribs or CategoryEdits::getXDayContribs, etc.), returns the HTML for an
// ordered list of the users.
////
function categoryHubContributorsToHtml($editsByUserId){
	$r = '';
	$NUM_TO_SHOW_BIG = 3; // all beyond this will use the small text-only badge

	if(is_array($editsByUserId) && count($editsByUserId) > 0){
		// TODO: Make the style not require #contributors id, but rather a list class.  This is needed since there will be more than one list per page.
		$r .= "<ul id='contributors' class='cathub-contributors-list cathub-contributors-list-wide'>\n";
		$numShown = 0;
		foreach($editsByUserId as $userId => $numEdits){
			if($numShown == $NUM_TO_SHOW_BIG){
				$r .= "</ul><ul id='contributors' class='cathub-contributors-list cathub-contributors-list-narrow'>\n";
			}
			$r .= "<li>";
			$r .= "<div class='listNumber".(($numShown >= $NUM_TO_SHOW_BIG)?" userInfoNoAvatar":"")."'>\n";
			$r .= ($numShown+1).".&nbsp;";
			$r .= "</div><div class='badgeWrapper'>\n";
			$user = User::newFromId($userId);
			$userData['user_id'] = $userId;
			$userData['user_name'] = $user->getName();
			$userData['edits'] = $user->getEditCount(); // spec is to show total edit count, not current relevant numEdits.
			$r .= Answer::getUserBadge($userData, ($numShown < $NUM_TO_SHOW_BIG));
			$r .= "</div>";
			$r .= "</li>";
			$numShown++;
		}
		$r .= "</ol>\n";
	}

	return $r;
} // end categoryHubContriutorsToHtml()

////
// Appends the HTML to 'r' for the "other section" which for Category Hubs is
// the Answered/Unanswered questions section.
////
function categoryHubOtherSection(&$catView, &$r){
	global $wgCatHub_useDefaultView;
	if(!$wgCatHub_useDefaultView){
		
		
		$r .= "[ANSWERED / UNANSWERED TABS HERE]";
		
		
	}
	return $wgCatHub_useDefaultView;
} // end categoryHubOtherSection()

////
// Appends the HTML to 'r' for the "other section" which for Category Hubs is
// the Answered/Unanswered questions section.
////
function categoryHubSubcategorySection(&$catView, &$r){
	global $wgCatHub_useDefaultView;
	if(!$wgCatHub_useDefaultView){

		# Don't show subcategories section if there are none.
		$r = '';
		$rescnt = count( $catView->children );
		if( $rescnt > 0 ) {
			# Showing subcategories
			$r .= "<div id=\"mw-subcategories\">\n";
			$r .= '<h3>' . wfMsg( 'subcategories' ) . "</h3>\n";
			$r .= implode($catView->children, "&nbsp;|&nbsp;");
			$r .= "\n</div>";
		}
	}
	return $wgCatHub_useDefaultView;
} // end categoryHubSubcategorySection()

?>
