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

// Since the entire article for the answered questions will be loaded, we create a more conservative limit.
// The maximum number of articles per tab because the whole article will be loaded (eg: max of 10 answered, 10 unanswered)
// WARNING: Defaults to 0 (since not this would involve a lot of extra data-loading that will only be needed if CategoryHubs is enabled).
global $wgCategoryHubArticleLimitPerTab;
$wgCategoryHubArticleLimitPerTab = 10; // required (otherwise will default to 0).


///// BEGIN - SETUP HOOKS /////
$wgHooks['LanguageGetMagic'][] = 'categoryHubAddMagicWords'; // setup names for parser functions (needed here)
$wgHooks['ParserAfterStrip'][] = 'categoryHubCheckForMagicWords';
$wgHooks['BeforePageDisplay'][] = 'categoryHubAdditionalScripts';
$wgHooks['MakeGlobalVariablesScript'][] = 'categoryHubJsGlobalVariables';

// Allows us to define a special order for the various sections on the page.
$wgHooks['FlexibleCategoryPage::openShowCategory'][] = 'categoryHubBeforeArticleText';
$wgHooks['FlexibleCategoryPage::closeShowCategory'][] = 'categoryHubAfterArticleText';

// Override the appearance of the sections on the category page.
$wgHooks['FlexibleCategoryViewer::init'][] = 'categoryHubInitViewer';
$wgHooks['FlexibleCategoryViewer::doCategoryQuery'][] = 'categoryHubDoCategoryQuery';
$wgHooks['FlexibleCategoryViewer::getCategoryTop'][] = 'categoryHubCategoryTop';
$wgHooks['FlexibleCategoryViewer::getOtherSection'][] = 'categoryHubOtherSection';
$wgHooks['FlexibleCategoryViewer::getSubcategorySection'][] = 'categoryHubSubcategorySection';
//$wgHooks['FlexibleCategoryViewer::getCategoryBottom'][] = 'categoryHubCategoryBottom';

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
// Before the page is rendered this gives us a chance to cram some Javascript in.
////
function categoryHubAdditionalScripts( &$out, &$sk ){
	global $wgScriptPath;
	$out->addScript('<link type="text/css" href="http://jqueryui.com/latest/themes/base/ui.all.css" rel="stylesheet" />');
	$out->addScript('<script type="text/javascript" src="http://jqueryui.com/latest/ui/ui.core.js"></script>');
	$out->addScript('<script type="text/javascript" src="http://jqueryui.com/latest/ui/ui.tabs.js"></script>');
	$out->addScript("<script type='text/javascript' src='$wgScriptPath/extensions/wikia/CategoryHubs/interactiveLists.js'></script>");
	$out->addScript("<script type='text/javascript' src='$wgScriptPath/extensions/wikia/CategoryHubs/tracking.js'></script>");
	return true;
} // end categoryHubAdditionalScripts()

////
// Adds global variables to the JS that will be needed by the CategoryHubs javascript.
// This includes internationalized messages that the JS will need.
////
function categoryHubJsGlobalVariables(&$vars){
	wfLoadExtensionMessages('CategoryHub');
	$vars['wgCatHubSaveButtonMsg'] = wfMsg('save');
	$vars['wgCatHubCancelButtonMsg'] = wfMsg('cancel');
	$vars['wgCatHubAnswerButtonMsg'] = wfMsg('cathub-button-answer');
	$vars['wgCatHubAnswerHeadingMsg'] = wfMsg('cathub-answer-heading');
	$vars['wgCatHubImproveAnswerButtonMsg'] = wfMsg('cathub-button-improve-answer');
	$vars['wgCatHubRephraseButtonMsg'] = wfMsg('cathub-button-rephrase');
	$vars['wgCatHubEditSuccessMsg'] = wfMsg('cathub-edit-success');

	global $wgStylePath;
	$vars['wgAjaxImageSrc'] = $wgStylePath."/common/images/ajax.gif";
	return true;
} // end categoryHubJsGlobalVariables()

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


///// THESE SECTIONS CHANGE SOME OF THE UNDER-THE-HOOD BEHAVIOR (SUCH AS ORDERING OF THE LISTS)  /////

////
// Called when the viewer is created.  We will use it to determine ahead of time if the page has rich categories enabled or not.
//
// Allows default behavior to happen.
////
function categoryHubInitViewer(&$flexibleCategoryViewer){
	global $wgCatHub_useDefaultView;

	// Since this and some other functions that need this info are executed before the parser gets called (and thus the hooks for checking the magic words),
	// we check for the magic word here (unless it was already found elsewhere).  This is used in categoryHubDoCategoryQuery and some of the
	// display functions that are called before the parser.
	if((!isset($wgCatHub_useDefaultView)) || (!$wgCatHub_useDefaultView)){
		$mw = MagicWord::get(CATHUB_NORICHCATEGORY);
		$article = Article::newFromID($flexibleCategoryViewer->getCat()->getTitle()->getArticleID());
		$wgCatHub_useDefaultView = (0 < $mw->match($article->getRawText())); // match does not return bool as documented. fix is committed to MediaWiki svn.
	}

	return true;
} // end categoryHubInitViewer()

////
// Overrides the default doCategoryQuery behavior to instead sort the pages by their last touched date (descending).
////
function categoryHubDoCategoryQuery(&$flexibleCategoryViewer){
	global $wgCatHub_useDefaultView;

	// Order by "page_touched" instead of alphabetically.  Keep in mind that if pagination starts being used, that
	// it will have to be modified to include the page_touched values in the 'from' and 'until' parameters instead of the page names (will require changes in
	// which parameter is used when because the order is DESC by default here and ascending by default normally).
	if(!$wgCatHub_useDefaultView){
		$dbr = wfGetDB( DB_SLAVE, 'category' );
		if( $flexibleCategoryViewer->from != '' ) {
			$pageCondition = 'page_touched >= ' . $dbr->addQuotes( $flexibleCategoryViewer->from );
			$flexibleCategoryViewer->flip = false;
		} elseif( $flexibleCategoryViewer->until != '' ) {
			$pageCondition = 'page_touched < ' . $dbr->addQuotes( $flexibleCategoryViewer->until );
			$flexibleCategoryViewer->flip = true;
		} else {
			$pageCondition = '1 = 1';
			$flexibleCategoryViewer->flip = false;
		}
		$res = $dbr->select(
			array( 'page', 'categorylinks', 'category' ),
			array( 'page_title', 'page_namespace', 'page_len', 'page_is_redirect', 'cl_sortkey',
				'cat_id', 'cat_title', 'cat_subcats', 'cat_pages', 'cat_files' ),
			array( $pageCondition, 'cl_to' => $flexibleCategoryViewer->title->getDBkey() ),
			__METHOD__,
			array( 'ORDER BY' => $flexibleCategoryViewer->flip ? 'page_touched' : 'page_touched DESC',
				'USE INDEX' => array( 'categorylinks' => 'cl_sortkey' ),
				'LIMIT'    => $flexibleCategoryViewer->limit + 1 ),
			array( 'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ),
				'category' => array( 'LEFT JOIN', 'cat_title = page_title AND page_namespace = ' . NS_CATEGORY ) )
		);

		$count = 0;
		$flexibleCategoryViewer->nextPage = null;
		while( $x = $dbr->fetchObject ( $res ) ) {
			if( ++$count > $flexibleCategoryViewer->limit ) {
				// We've reached the one extra which shows that there are
				// additional pages to be had. Stop here...
				$flexibleCategoryViewer->nextPage = $x->cl_sortkey;
				break;
			}

			$title = Title::makeTitle( $x->page_namespace, $x->page_title );

			if( $title->getNamespace() == NS_CATEGORY ) {
				$cat = Category::newFromRow( $x, $title );
				$flexibleCategoryViewer->addSubcategoryObject( $cat, $x->cl_sortkey, $x->page_len );
			} elseif( $flexibleCategoryViewer->showGallery && $title->getNamespace() == NS_FILE ) {
				$flexibleCategoryViewer->addImage( $title, $x->cl_sortkey, $x->page_len, $x->page_is_redirect );
			} else {
				if( wfRunHooks( "CategoryViewer::addPage", array( &$flexibleCategoryViewer, &$title, &$x ) ) ) {
					$flexibleCategoryViewer->addPage( $title, $x->cl_sortkey, $x->page_len, $x->page_is_redirect );
				}
			}
		}
		$dbr->freeResult( $res );
	}

	return $wgCatHub_useDefaultView;
} // end categoryHubDoCategoryQuery()

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
	/*#page_bar{ display:none; }*/
	#siteNotice { display: none; }
	#answers_article{ padding-top:0px; }
	#cathub-title-bar{
		background-image:url($wgScriptPath/extensions/wikia/CategoryHubs/cathub_title_bg.png);
		/* Stretch across entire div#article. */
		margin-left: -30px;
		padding-left: 30px;
		padding-right: 30px;
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
	.ui-widget-header{
		background-image:url($wgScriptPath/extensions/wikia/CategoryHubs/tab_navbar_bg.png);
	}
	.cathub-actual-answer { position: relative; }
	.cathub-add-answer-wrapper { margin-right: 150px; }
	.cathub-actual-answer .cathub-button {
		position: absolute;
		top: 1em;
		right: 0;
	}
	</style>";

	// Build up the title bar by its various pieces
	$r .= "<div id='cathub-title-bar'>\n";

	// Fetch the icon for the corresponding wiki if there is one.
	WikiFactory::isUsed(true);
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
// TODO: RE-ENABLE DISPLAY OF THIS WHEN WE'RE ACTUALLY IMPLEMENTING IT.
//	$r .= " <div style='float:right;border-left:#ccf 1px solid'>\n";
//	$r .= " <img id='cathub-notify-me' src='$wgScriptPath/extensions/wikia/CategoryHubs/notify.png' width='114' height='74' style='float:right;padding:5px;'/>";
//	$r .= "</div>";

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
		$aTitle = wfMsgExt('cathub-progbar-mouseover-answered', array(), $aPercent);
		$uTitle = wfMsgExt('cathub-progbar-mouseover-not-answered', array(), $uPercent);

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

	$r .= "<div class='cathub-progbar-label cathub-progbar-label-left'>".wfMsgExt('cathub-answered', array())."</div>";
	$r .= "<div class='cathub-progbar-label cathub-progbar-label-right'>".wfMsgExt('cathub-unanswered', array())."</div>";
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
	$r .= categoryHubContributorsToHtml($categoryEdits->getXDayContribs(CATHUB_RECENT_CONTRIBS_LOOKBACK_DAYS, $NUM_CONTRIBS_PER_SECTION));
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
		$r .= "<ul class='contributors cathub-contributors-list cathub-contributors-list-wide'>\n";
		$numShown = 0;
		foreach($editsByUserId as $userId => $numEdits){
			if($numShown == $NUM_TO_SHOW_BIG){
				$r .= "</ul><ul class='contributors cathub-contributors-list cathub-contributors-list-narrow userInfoNoAvatar'>\n";
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
	wfProfileIn(__METHOD__);
	global $wgCatHub_useDefaultView;
	if(!$wgCatHub_useDefaultView){
		global $wgUser;

		$ti = htmlspecialchars( $catView->title->getText() );
		$cat = $catView->getCat();

		if ( $wgUser->isAnon() && $cat->getSubcatCount() > 0 && ( !empty($catView->answers["answered_questions"]) || !empty($catView->answers["unanswered_questions"]) ) ) {
			//$r .= AdEngine::getInstance()->getPlaceHolderDiv('ANSWERSCAT_LEADERBOARD_U');
		}

		$r .= "<div id='tabs'>\n"; // jquery ui tabs widget

		// The tabs.
		$r .= "<ul>\n";
		$r .= "<li><a href='#cathub-tab-unanswered' id=\"cathub-tablink-unanswered\"><span>".wfMsgExt('Unanswered_category', array())."</span></a></li>\n";
		$r .= "<li><a href='#cathub-tab-answered'   id=\"cathub-tablink-answered\"><span>".wfMsgExt('Answered_category', array())."</span></a></li>\n";
		$r .= "</ul>\n";

		// Unanswered questions in this category.
		$UN_CLASS = "unanswered_questions";
		$r .= "<div id=\"cathub-tab-unanswered\">\n";
		if(empty($catView->answerArticles[$UN_CLASS]) || count($catView->answerArticles[$UN_CLASS]) == 0){
			$r .= "<div class='no-questions-now'>";
			$r .= wfMsgExt('cathub-no-unanswered-questions', array());
			$r .= "</div>";
		} else {
			$r .= "<ul class='interactive-questions'>\n";
			
			foreach($catView->answerArticles[$UN_CLASS] as $qArticle){
				$r .= "<li class=\"$UN_CLASS\">\n";

				// Button to trigger the form for answering inline.
				$r .= "<div class='cathub-button hideUntilHover' style='float:right'>\n";
				$r .= "<a rel='nofollow' class='bigButton cathub-button-answer' href='javascript:void(0)'><big>";
				$r .= wfMsgExt('cathub-button-answer', array())."</big><small>&nbsp;</small></a>\n";
				$r .= "</div>\n";

				// Question & attribution for last edit.
				$title = $qArticle->getTitle();
				$r .= "<span class=\"$UN_CLASS cathub-article-link\">" . $catView->getSkin()->makeKnownLinkObj( $title, $title->getPrefixedText() . '?' ) . '</span>';
				$r .= categoryHubGetAttributionByArticle($qArticle);

				$r .= "</li>\n";
			}
			$r .= "</ul>\n";
		}
		$r .= "</div>\n";
		if ( $wgUser->isAnon() ) {
			//$r .= AdEngine::getInstance()->getPlaceHolderDiv('ANSWERSCAT_BOXAD_U');
		}

		// Answered questions in this category.
		$ANS_CLASS = "answered_questions";
		$r .= "<div id=\"cathub-tab-answered\">\n";
		if(empty($catView->answerArticles[$ANS_CLASS]) || count($catView->answerArticles[$ANS_CLASS]) == 0){
			$r .= "<div class='no-questions-now'>";
			$r .= wfMsgExt('cathub-no-answered-questions', array());
			$r .= "</div>";
		} else {
			global $wgParser, $wgMessageCache;
			$tmpParser = new Parser();
			$tmpParser->setOutputType(OT_HTML);
			$tmpParserOptions = new ParserOptions();

			$r .= "<ul class='interactive-questions'>\n";
			foreach($catView->answerArticles[$ANS_CLASS] as $qArticle){
				$r .= "<li class=\"$ANS_CLASS\">\n";

				// Button to trigger the form for changing an answer inline.
				$r .= "<div class='cathub-button hideUntilHover' style='float:right;'>\n";
				$r .= "<a rel='nofollow' class='bigButton cathub-button-answer' href='javascript:void(0)'><big>";
				$r .= wfMsgExt('cathub-button-improve-answer', array())."</big><small>&nbsp;</small></a>\n";
				$r .= "</div>\n";

				// Question & attribution for last edit.
				$title = $qArticle->getTitle();
				$r .= "<span class=\"$ANS_CLASS cathub-article-link\">" . $catView->getSkin()->makeKnownLinkObj( $title, $title->getPrefixedText() . '?' ) . '</span>';
				// TODO: RESTORE THIS WHEN rephrase IS WORKING.
				//$r .= "&nbsp;<span class='cathub-button-rephrase hideUntilHover'><a href='javascript:void(0)'>".wfMsgExt('cathub-button-rephrase', array())."</a></span>";
				$r .= categoryHubGetAttributionByArticle($qArticle, true); //'true' uses messages for 'answered'

				// Show the  actual answer.
				$r .= "<div class='cathub-actual-answer'>";
				$r .= "<span class='cathub-answer-heading'>".wfMsgExt('cathub-answer-heading', array())."</span><br/>\n";
				$r .= $tmpParser->parse($qArticle->getRawText(), $title, $tmpParserOptions, false)->getText();
				$r .= "</div>\n";
	
				$r .= "</li>\n";
			}
			$r .= "</ul>\n";
			if ( $wgUser->isAnon() ) {
				//$r .= AdEngine::getInstance()->getPlaceHolderDiv('ANSWERSCAT_BOXAD_A');
			}
		}
		$r .= "&nbsp;</div>\n";

		$r .= "</div>\n"; // end of #tabs
	}

	wfProfileOut(__METHOD__);
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

////
// Returns a string containing the HTML for the attribution line which can be used in
// the answered/unanswered lists given an article.
//
// If 'answered' then the text will say "answered by" instead of "asked by".
////
function categoryHubGetAttributionByArticle($qArticle, $answered=false){
	global $wgStylePath;
	$title = $qArticle->getTitle();
	$timestamp = $qArticle->getTitle()->getTouched();
	$lastUpdate = wfTimeFormatAgo($timestamp);
	$userId = $qArticle->getUser();
	$userLink = "";
	if($userId > 0){
		$userText = $qArticle->getUserText();
		$userPageTitle = Title::makeTitle(NS_USER, $userText);
		$userPageLink = $userPageTitle->getLocalUrl();
		$userPageExists = $userPageTitle->exists();
		$userLinkText = $userPageExists ? '<a id="fe_user_icon" rel="nofollow" href="'.$userPageLink.'">' : '';
		$userLinkText .= "<img src='$wgStylePath/monobook/blank.gif' id='fe_user_img' class='sprite' alt='".wfMsg('userpage')."' />";
		$userLinkText .= $userPageExists ? '</a>' : '';
		$userLinkText .= '<a id="fe_user_link" rel="nofollow" '.($userPageExists ? '' : ' class="new" ').'href="'.$userPageLink.'">'.$userText.'</a>';
		$userLink = wfMsgExt('cathub-question-asked-by', array(), $userLinkText);
	} else {
		$userLink = wfMsgExt('cathub-anon-username', array());
	}
	if($answered){
		$asked = wfMsgExt('cathub-question-answered-ago', array(), $lastUpdate, $userLink);
	} else {
		$asked = wfMsgExt('cathub-question-asked-ago', array(), $lastUpdate, $userLink);
	}
	return "<div class='cathub-asked'>$asked</div>";
} // end categoryHubGetAttributionByArticle()

?>
