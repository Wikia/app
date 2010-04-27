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
////

if ( ! defined( 'MEDIAWIKI' ) ){
	die("Extension file.  Not a valid entry point");
}

define('CATHUB_NORICHCATEGORY', 'CATHUB_NORICHCATEGORY');
define('CATHUB_RECENT_CONTRIBS_LOOKBACK_DAYS', 7);
define('ANSWERED_CATEGORY', 'answered_questions');
define('UNANSWERED_CATEGORY', 'unanswered_questions');

// Since the entire article for the answered questions will be loaded, we create a more conservative limit.
// The maximum number of articles per tab because the whole article will be loaded (eg: max of 10 answered, 10 unanswered)
global $wgCategoryHubArticleLimitPerTab;
// WARNING: Defaults to 0 (since not this would involve a lot of extra data-loading that will only be needed if CategoryHubs is enabled).
$wgCategoryHubArticleLimitPerTab = 10; // required (otherwise will default to 0).

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
        $wgHooks['ParserFirstCallInit'][] = 'CategoryHubs_initParserHook';
} else {
        $wgExtensionFunctions[] = 'CategoryHubs_initParserHook';
}

if( $wgEnableCategoryHubsExt ) {
	///// BEGIN - SETUP HOOKS /////
	$wgHooks['LanguageGetMagic'][] = 'categoryHubAddMagicWords'; // setup names for parser functions (needed here)
	$wgHooks['ParserAfterStrip'][] = 'categoryHubCheckForMagicWords';
	// TODO: FIXME: Can this be put somewhere better so that the scripts are only included on CategoryHubs rather than all Answers pages?
	$wgHooks['BeforePageDisplay'][] = 'categoryHubAdditionalScripts';
	$wgHooks['MakeGlobalVariablesScript'][] = 'categoryHubJsGlobalVariables';

	// Allows us to define a special order for the various sections on the page.
	$wgHooks['CategoryViewer::getOtherSection'][] = 'categoryHubPreviewCheck'; // only for neutering display of previews.
	$wgHooks['FlexibleCategoryPage::openShowCategory'][] = 'categoryHubBeforeArticleText';
	$wgHooks['FlexibleCategoryPage::closeShowCategory'][] = 'categoryHubAfterArticleText';

	// Override the appearance of the sections on the category page.
	$wgHooks['FlexibleCategoryViewer::init'][] = 'categoryHubInitViewer';
	$wgHooks['FlexibleCategoryViewer::doCategoryQuery'][] = 'categoryHubDoCategoryQuery';
	$wgHooks['FlexibleCategoryViewer::getCategoryTop'][] = 'categoryHubCategoryTop';
	$wgHooks['FlexibleCategoryViewer::getOtherSection'][] = 'categoryHubOtherSection';
	$wgHooks['FlexibleCategoryViewer::getSubcategorySection'][] = 'categoryHubSubcategorySection';
	//$wgHooks['FlexibleCategoryViewer::getCategoryBottom'][] = 'categoryHubCategoryBottom';
}

$wgAjaxExportList[] = 'wfAnswersTagsAjaxGetArticles';

// parser hooks for Q&A project tags
function CategoryHubs_initParserHook(&$parser) {
	wfLoadExtensionMessages('CategoryHub');
	global $wgAnswersTabTags;

	$wgAnswersTabTags = 0;
	$parser->setHook( 'answers_stats', 'wfAnswersStatsParserHook' );
	$parser->setHook( 'answers_leaderboard_all_time', 'wfAnswersLeaderboardAllTimeParserHook' );
	$parser->setHook( 'answers_leaderboard_last_7_days', 'wfAnswersLeaderboardLastParserHook' );
	$parser->setHook( 'answers_tabs', 'wfAnswersTabsParserHook' );
	$parser->setHook( 'answers_subcategories', 'wfAnswersSubcategoriesParserHook' );

        return true;
}

function wfAnswersStatsParserHook( $input, $args, $parser ) {
	$r = '';

	// todo get data from the entire site for that

	$answered = CategoryHub::getAnsweredCategory();
	$unanswered =  CategoryHub::getUnAnsweredCategory();

	$answeredCategoryEdits = CategoryEdits::newFromName( $answered );		
	$unansweredCategoryEdits = CategoryEdits::newFromName( $unanswered );	

	$PROG_BAR_WIDTH = 250; // in pixels.  If this is changed, make sure to re-evaluate MIN_PERCENT_TO_SHOW_TEXT_ON_LEFT
	$MIN_PERCENT_TO_SHOW_TEXT = 11; // if cat is this percentage or more complete, the percentage will be shown in left side of progress bar.
	$MIN_PERCENT_TO_ADD_SPACE = 14; // adds a second non-breaking space before % answered if there is room for it (to make it look better).
	$r .= "<div style='display:table;width:$PROG_BAR_WIDTH"."px'>"; // wraps the progress bar and the labels below it
	$r .= "<div class='cathub-progbar-wrapper' style='width:$PROG_BAR_WIDTH"."px'>";

	$countAnswered = $answeredCategoryEdits->getPageCount();
	$countUnAnswered = $unansweredCategoryEdits->getPageCount();
	
	$percentAnswered = ( 100 * $countAnswered ) / ( $countAnswered + $countUnAnswered ) ;

	$allQuestions = $countAnswered + $countUnAnswered;
	if($percentAnswered <= 0){
		$percentAnswered = 0;
		$r .= "<div class='cathub-progbar-unanswered' style='width:$PROG_BAR_WIDTH'>".wfMsgExt('cathub-progbar-none-done', array())."</div>\n";
	} else if($percentAnswered >= 100){
		if ( empty($countUnAnswered) ) {
			$percentAnswered = 100;
			$r .= "<div class='cathub-progbar-answered' style='width:$PROG_BAR_WIDTH' title=''>".wfMsgExt('cathub-progbar-all-done', array())."</div>\n";
		} else {
			// some unanswered questions
			$r .= "<div class='cathub-progbar-answered' style='width:$PROG_BAR_WIDTH' title=''>".wfMsgExt('cathub-progbar-allmost-done', 'parsemag', $countUnAnswered)."</div>\n";
		}
	} else {
		// TODO: EXTRACT THIS TO A FUNCTION WHICH WILL MAKE A BANDWIDTH-EFFICIENT PROGRESS BAR FOR ANY USE (IF POSSIBLE TO DO CLEANLY... MIGHT HAVE TO REQUIRE IT TO BE ANSWERS-SPECIFIC).
		#$aPercent = substr($percentAnswered, 0, -1); // removes the "%" sign
		$aPercent = $percentAnswered;
		$uPercent = (100 - $percentAnswered);
		$aWidth = round(($PROG_BAR_WIDTH * $aPercent) / 100);
		$uWidth = $PROG_BAR_WIDTH - $aWidth;
		$aTitle = wfMsgExt('cathub-progbar-mouseover-answered', array(), $aPercent, $countAnswered);
		$uTitle = wfMsgExt('cathub-progbar-mouseover-not-answered', array(), $uPercent, $countUnAnswered);

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

		$r .= "<div class='cathub-progbar cathub-progbar-answered answers-parser-left' style='width:$aWidth"."px' title='$aTitle'>$aText</div>";
		$r .= "<div class='cathub-progbar cathub-progbar-unanswered answers-parser-right' style='width:$uWidth"."px' title='$uTitle'>$uText</div>";
	}
	$r .= "</div>"; // close the wrapper on the progress bar

	$r .= "<div class='cathub-progbar-label cathub-progbar-label-left answers-parser-left'>".wfMsgExt('cathub-progbar-label-answered', array())."</div>";
	$r .= "<div class='cathub-progbar-label cathub-progbar-label-right answers-parser-right'>".wfMsgExt('cathub-progbar-label-unanswered', array())."</div>";
	$r .= "</div>"; // close the wrapper on the div containing the progress bar and the labels.

	return $r;
}

function wfAnswersLeaderboardAllTimeParserHook( $input, $args, $parser ) {
	$out = '';
	wfLoadExtensionMessages( 'CategoryHub' );
	$NUM_CONTRIBS_PER_SECTION = 10;
	$show_staff = false;

	$out .= "<div class='tagTopContribsAllTime'>\n";
	$out .= "<h3>".wfMsgExt('cathub-top-contribs-all-time', array())."</h3>";
	$out .= categoryHubContributorsToHtml( wfAnswersGetContribs( $show_staff, $NUM_CONTRIBS_PER_SECTION ) );
	$out .= "</div>\n";
	$out .= "<div style='clear:both'>&nbsp;</div>\n";

	return $out;
		
}

function wfAnswersLeaderboardLastParserHook( $input, $args, $parser ) {
	$out = '';
	wfLoadExtensionMessages( 'CategoryHub' );
	$NUM_CONTRIBS_PER_SECTION = 10;
	$show_staff = false;

	$out .= "<div class='tagTopContribsRecent'>\n";
	$out .= "<h3>".wfMsgExt('cathub-top-contribs-recent', 'parsemag', CATHUB_RECENT_CONTRIBS_LOOKBACK_DAYS)."</h3>";
	$out .= categoryHubContributorsToHtml(wfAnswersGetXDayContribs(CATHUB_RECENT_CONTRIBS_LOOKBACK_DAYS, $show_staff, $NUM_CONTRIBS_PER_SECTION));
	$out .= "</div>\n";
	$out .= "<div style='clear:both'>&nbsp;</div>\n";

	return $out;
}

/*


	@params

*/

function wfAnswersGetContribs($show_staff = true, $limit = 30, $offset = 0) {
	global $wgMemc;
	wfProfileIn( __METHOD__ );

	$memkey = wfMemcKey( 'answerstag_contribs', intval($show_staff), $limit, $offset );
	$users = $wgMemc->get( $memkey );

	if ( empty($users) ) {
		$group_cond = "ug_group = 'bot'";
		if ( empty($show_staff) ) {
			$group_cond = "ug_group in ('bot', 'staff')";
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select (
				array( 'category_user_edits', 'user_groups' ),
				array( 'cue_user_id as user_id, cue_count as cnt' ),
				array( "ug_user is null" ),
				__METHOD__,
				array(
					'ORDER BY' => 'cue_count DESC',
					'LIMIT' => $limit,
					'OFFSET' => $offset * $limit
				     ),
				array(
					'user_groups' => array( 'LEFT JOIN',
						implode ( ' AND ',
							array(
								"cue_user_id = ug_user",
								$group_cond
							     )
							)
						)
				     )
					);
		if ( $dbr->numRows($res) ) {
			$users = array();
			while( $oRow = $dbr->fetchObject($res) ) {
				$users[$oRow->user_id] = $oRow->cnt;
			}
			$dbr->freeResult($res);
			$wgMemc->set( $memkey, $users, 60*2 );
		}
	}

	wfProfileOut( __METHOD__ );
	return $users;
}

/*

	@params

*/

function wfAnswersGetXDayContribs($days = 7, $show_staff = true, $limit = 30, $offset = 0) {
	global $wgMemc;
	wfProfileIn( __METHOD__ );

	$memkey = wfMemcKey( 'answerstag_xdayscontribs', intval($show_staff), $days, $limit, $offset );
	$users = $wgMemc->get( $memkey );

	if ( empty($users) ) {
		$group_cond = "ug_group = 'bot'";
		if ( empty($show_staff) ) {
			$group_cond = "ug_group in ('bot', 'staff')";
		}
		$min_date = date('Y-m-d', time() - $days * 24 * 60 * 60);
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select (
				array( 'category_edits', 'user_groups' ),
				array( 'ce_user_id as user_id, ce_count as cnt' ),
				array(
					"ug_user is null",
					"ce_date >= '$min_date'"
				     ),
				__METHOD__,
				"",
				array(
					'user_groups' => array( 'LEFT JOIN',
						implode ( ' AND ',
							array(
								"ce_user_id = ug_user",
								$group_cond
							     )
							)
						)
				     )
				);

		if ( $dbr->numRows($res) ) {
			$users = $tmp = array();
			while( $oRow = $dbr->fetchObject($res) ) {
				if ( !isset($tmp[$oRow->user_id]) ) {
					$tmp[$oRow->user_id] = 0;
				}
				$tmp[$oRow->user_id] += $oRow->cnt;
			}
			$dbr->freeResult($res);
			if ( count($tmp) > 0 ) {
				arsort($tmp);
				$users = array_slice($tmp, $limit * $offset, $limit, true);
			}
			$wgMemc->set( $memkey, $users, 60*15 );
		}
	}

	wfProfileOut( __METHOD__ );
	return $users;
}

/*

	@params $category Title

*/

function wfAnswersTagsDoCategoryQuery( $category ) {
	global $wgCategoryMagicGallery, $wgOut, $wgTitle;
	$showGallery = $wgCategoryMagicGallery && !$wgOut->mNoGallery;
			
	$dbr = wfGetDB( DB_SLAVE, 'category' );

	$res = $dbr->select(
			array( 'page', 'categorylinks', 'category' ),
			array( 'page_title', 'page_namespace', 'page_len', 'page_is_redirect', 'cl_sortkey',
				'cat_id', 'cat_title', 'cat_subcats', 'cat_pages', 'cat_files' ),
			array( 'cl_to' => $category->getDBkey() ),
			__METHOD__,
			array( 'ORDER BY' => 'cl_sortkey',
				'USE INDEX' => array( 'categorylinks' => 'cl_sortkey' ) ),
			array( 'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ),
				'category' => array( 'LEFT JOIN', 'cat_title = page_title AND page_namespace = ' . NS_CATEGORY ) )
			);

	$articles = array();

	while( $x = $dbr->fetchObject( $res ) ) {
		$title = Title::makeTitle( $x->page_namespace, $x->page_title );
		$ns = $title->getNamespace();

		// in original function, categories and files aren't added as "pages" - is that ok? todo ask
		if( ( $ns != NS_CATEGORY ) && ( !$showGallery || $ns != NS_FILE ) ) {
			if( $title->getText() != $wgTitle->getText() ) {
				$articles[] = Article::newFromID( $title->getArticleID() );
			}
		}
	}
	return $articles;
}

function wfAnswersTabsParserHook( $input, $args, $parser ) {
	global $wgAnswersTabTags;
	$out = '';
	if( $wgAnswersTabTags == 0 ) {
		$answered = CategoryHub::getAnsweredCategory();
		$unanswered =  CategoryHub::getUnAnsweredCategory();

		$answeredTitle = Title::newFromText( $answered, NS_CATEGORY );
		$unansweredTitle = Title::newFromText( $unanswered, NS_CATEGORY );

		$answeredArticles = wfAnswersTagsDoCategoryQuery( $answeredTitle );
		$unansweredArticles = wfAnswersTagsDoCategoryQuery( $unansweredTitle );
		categoryHubRenderTabs( null, $answeredArticles, $unansweredArticles, &$out, &$parser );
		$wgAnswersTabTags++;
	}
		
	return $out;
}

function wfAnswersSubcategoriesParserHook( $input, $args, $parser ) {
	global $wgUser;
	$out = '';

	$dbr = wfGetDB( DB_SLAVE );
	$result_array = array () ;
	$res = $dbr->select (
			array ('category') ,
			array ('cat_title', 'cat_pages' ) ,
			array(),
			__METHOD__ ,
			array ( 'ORDER_BY'  => 'cat_title' ,
				'USE_INDEX' => 'cat_title'
			      )
			) ;

	$sk = $wgUser->getSkin();
	while( $x = $dbr->fetchObject ( $res ) ) {
			$title = Title::newFromText( $x->cat_title, NS_CATEGORY );
			$result_array [] = $sk->makeKnownLinkObj( $title, $title->getText() ) ;
	}

	if (!empty ($result_array) ) {
		$out .= "<div class=\"tags-hub-subcategories\">\n";
		$out .= '<h3>' . wfMsg( 'cathub-tags' ) . "</h3>\n";

		$out .= implode($result_array, "&nbsp;|&nbsp;");
		$out .= "\n</div>";

	}
	return $out;
}

function wfAnswersTagsAjaxGetArticles( ) {
	global $wgRequest;	
	$type = $wgRequest->getVal( 'type', 'u' );
	$offset = $wgRequest->getVal( 'offset', 0 );

	$UN_CLASS = "unanswered_questions";
	$ANS_CLASS = "answered_questions";
	$U_SUFFIX = "_u"; // appended to url params to differentiate whihc tab is being paginated
	$A_SUFFIX = "_a";

	$r = '';

	if( 'a' == $type ) {
		$answered = CategoryHub::getAnsweredCategory();
		$answeredTitle = Title::newFromText( $answered, NS_CATEGORY );
		$answeredArticles = wfAnswersTagsDoCategoryQuery( $answeredTitle );
		$numRet = count( $answeredArticles );
		wfCategoryHubGetAnsweredQuestions( $answeredArticles, &$r, $ANS_CLASS, $A_SUFFIX, $numRet, $offset, null, true );
	} else {
		$unanswered =  CategoryHub::getUnAnsweredCategory();
		$unansweredTitle = Title::newFromText( $unanswered, NS_CATEGORY );
		$unansweredArticles = wfAnswersTagsDoCategoryQuery( $unansweredTitle );
		$numRet = count( $unansweredArticles );
		wfCategoryHubGetUnansweredQuestions( $answeredArticles, &$r, $ANS_CLASS, $A_SUFFIX, $numRet, $offset, null, true );
	}

	return Wikia::json_encode(
			array(
				"error" => 0,
				"text"  => $r
			     )
                );
}

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

/**
 * Used to add the __NORICHCATEGORY__ behavior switch (magic word).
 * Bound to $wgHooks['LanguageGetMagic'][]
 */
function categoryHubAddMagicWords(&$magicWords, $langCode){
	$magicWords[CATHUB_NORICHCATEGORY] = array( 0, '__NORICHCATEGORY__' );
	return true;
}

/**
 * Before the page is rendered this gives us a chance to cram some Javascript in.
 */
function categoryHubAdditionalScripts( &$out, &$sk ){
	global $wgExtensionsPath,$wgStyleVersion;

	$out->addStyle( "$wgExtensionsPath/wikia/CategoryHubs/CategoryHubs.css?$wgStyleVersion" );
	$out->addScript("<link type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css' rel='stylesheet' />\n");
	$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/CategoryHubs/jquery-ui.min.js?$wgStyleVersion'></script>\n");
	$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/CategoryHubs/interactiveLists.js?$wgStyleVersion'></script>\n");
	$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/CategoryHubs/tracking.js?$wgStyleVersion'></script>\n");
	return true;
} // end categoryHubAdditionalScripts()

/**
 * Adds global variables to the JS that will be needed by the CategoryHubs javascript.
 * This includes internationalized messages that the JS will need.
 */
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

	global $wgTitle;
	$vars['wgPurgeCategoryHubsCacheUrl'] = $wgTitle->getFullURL('action=purge&exitwithoutcontent=1');
	return true;
} // end categoryHubJsGlobalVariables()

/**
 * Determines if the magic word is present for disabling the Category Hub and defaulting to previous behavior.
 */
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

/**
 * Used to intercept calls to CategoryPage::openShowCategory just for the use of disabling the display of extra things on
 * preview pages when CategoryHubs is enabled..
 */
function categoryHubPreviewCheck(&$catView, &$r){
	global $wgRequest;

	// If this is a preview page, return false so that the default behavior of getOtherSection doesn't happen.
	return (!$wgRequest->getCheck('wpPreview'));
} // end categoryHubPreviewCheck()

/**
 * Overrides FlexibleCategoryPage::openShowCategory to allow us to choose which sections to display
 * before the category's article text.
 */
function categoryHubBeforeArticleText(&$flexibleCategoryPage){
	global $wgCatHub_useDefaultView;

	global $wgRequest;
	$wgCatHub_useDefaultView = $wgRequest->getBool("useoldcats", $wgCatHub_useDefaultView);

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

/**
 * Overrides FlexibleCategoryPage::closeShowCategory to allow us to choose which sections to display
 * after the category's article text.
 */
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

/**
 * Called when the viewer is created.  We will use it to determine ahead of time if the page has rich categories enabled or not.
 *
 * Allows default behavior to happen.
 */
function categoryHubInitViewer(&$flexibleCategoryViewer){
	global $wgCatHub_useDefaultView;

	// Since this and some other functions that need this info are executed before the parser gets called (and thus the hooks for checking the magic words),
	// we check for the magic word here (unless it was already found elsewhere).  This is used in categoryHubDoCategoryQuery and some of the
	// display functions that are called before the parser.
	if((!isset($wgCatHub_useDefaultView)) || (!$wgCatHub_useDefaultView)){
		$mw = MagicWord::get(CATHUB_NORICHCATEGORY);
		$article = Article::newFromID($flexibleCategoryViewer->getCat()->getTitle()->getArticleID());
		$wgCatHub_useDefaultView = ($article && (0 < $mw->match($article->getRawText()))); // match does not return bool as documented. fix is committed to MediaWiki svn.
	}

	return true;
} // end categoryHubInitViewer()

/**
 * Overrides the default doCategoryQuery behavior to instead sort the pages by their last touched date (descending).
 */
function categoryHubDoCategoryQuery(&$flexibleCategoryViewer){
	global $wgCatHub_useDefaultView;

	// Order by "page_touched" instead of alphabetically.  Keep in mind that if pagination starts being used, that
	// it will have to be modified to include the page_touched values in the 'from' and 'until' parameters instead of the page names (will require changes in
	// which parameter is used when because the order is DESC by default here and ascending by default normally).
	if(!$wgCatHub_useDefaultView){
		// If we haven't passed the limit, store the entire article for the answer so that extensions (such as CategoryHubs) can display in-depth data.
		global $wgCategoryHubArticleLimitPerTab, $wgRequest; // A more conservative limit than the normal articles-per-page limit since we're loading the entire article.
		$limit = $wgCategoryHubArticleLimitPerTab;
		$offset_u = $wgRequest->getVal('offset_u', 0);
		$offset_a = $wgRequest->getVal('offset_a', 0);

		$categoryEditsObj = CategoryEdits::newFromName($flexibleCategoryViewer->getCat()->getName());
		$flexibleCategoryViewer->answerArticles[ANSWERED_CATEGORY] = array();
		$flexibleCategoryViewer->answerArticles[UNANSWERED_CATEGORY] = array();

		$answeredCategory = CategoryHub::getAnsweredCategory();
		$answered = $categoryEditsObj->getPages($answeredCategory, array(), $limit, $offset_a);
		if(is_array($answered)){
			foreach($answered as $ans){
				$flexibleCategoryViewer->answerArticles[ANSWERED_CATEGORY][] = Article::newFromID($ans['id']);
			}
		}
		$unAnsweredCategory = CategoryHub::getUnAnsweredCategory();
		$unanswered = $categoryEditsObj->getPages($unAnsweredCategory, array(), $limit, $offset_u);
		if(is_array($unanswered)){
			foreach($unanswered as $unans){
				$flexibleCategoryViewer->answerArticles[UNANSWERED_CATEGORY][] = Article::newFromID($unans['id']);
			}
		}

		// Ordering...
		if( $flexibleCategoryViewer->from != '' ) {
			$flexibleCategoryViewer->flip = false;
		} elseif( $flexibleCategoryViewer->until != '' ) {
			$flexibleCategoryViewer->flip = true;
		} else {
			$flexibleCategoryViewer->flip = false;
		}

		$categories = array();
		$categoryEditsObj->getSubcategories($categories);
		foreach ($categories as $id => $title) {
			$cat = Category::newFromName($title);
			$flexibleCategoryViewer->addSubcategoryObject($cat, $title, 0);
		}
	}

	return $wgCatHub_useDefaultView;
} // end categoryHubDoCategoryQuery()

///// THE SECTIONS BELOW MODIFY THE APPEARANCE OF EACH SECTION /////


/**
 * Returns the HTML for the top of the category hub page.  This includes our modified title bar and
 * the Top Contributors section.
 */
function categoryHubCategoryTop(&$catView, &$r){

	global $wgCatHub_useDefaultView;
	if(!$wgCatHub_useDefaultView){

		// Special-case.  If this is a purge, clear memecached.
		// If this was a special ajax purge-only request then just exit after the purge.
		global $wgRequest;
		if($wgRequest->getVal('action') == "purge"){
			$categoryEdits = CategoryEdits::newFromId($catView->getCat()->getId());

			$answeredCategory = CategoryHub::getAnsweredCategory();
			$unAnsweredCategory = CategoryHub::getUnAnsweredCategory();
			$categoryEdits->purgePercentInCats($answeredCategory, $unAnsweredCategory);
			$categoryEdits->purgePagesInCat($answeredCategory);
			$categoryEdits->purgePagesInCat($unAnsweredCategory);

			if($wgRequest->getVal('exitwithoutcontent') == "1"){
				print "1"; // to indicate success in an easier-to-debug manner than just headers
				exit;
			}
		}

		$countQuestions = categoryHubTitleBar($catView, $r);
		if ( $countQuestions > 0 ) {
			categoryHubTopContributors($catView, $r);
		}
	}
	return $wgCatHub_useDefaultView;
} // end categoryHubCategoryTop()

/**
 * Displays the custom title bar (replaces the normal title) this includes the icon of the associated
 * wiki (if applicable),  the title, progress bar or how many are answered, and the notification button.
 */
function categoryHubTitleBar(&$catView, &$r){
	// Build up the title bar by its various pieces
	$r .= "<div id='cathub-title-bar'>\n";

	$logoSrc = categoryHubGetLogo($catView->getCat()->getName());
	if($logoSrc != ""){
		$r .= '<img src="'.$logoSrc.'" alt="" height="78" class="cathub-title-bar-wikilogo"/>';
	}

	// Button for being notified of any new questions tagged with this category.
	// TODO: IMPLEMENT BACKEND FOR TRACKING NOTIFICATIONS
	// TODO: IMPLEMENT THE EXTENSION CODE FOR SENDING OUT NOTIFICATIONS WHEN A NEW CATEGORIZATION IS ADDED
	// TODO: IMPLEMENT THE AJAX FOR CLICKING THIS BUTTON
	// TODO: IMPLEMENT THE NEW APPEARANCE OF THIS BUTTON FOR A USER WHO IS ALREADY FOLLOWING THIS CATEGORY
	// TODO: GET THE CORRECT ARTWORK FOR BOTH THE ALREADY-NOTIFIED AND UN-NOTIFIED STATES OF THE BUTTON
// TODO: RE-ENABLE DISPLAY OF THIS WHEN WE'RE ACTUALLY IMPLEMENTING IT.
// TODO: REMOVE THE 'style' DECLARATIONS ONCE WE'RE USING THIS AND GET THEM INTO CSS FILES.
//	$r .= " <div style='float:right;border-left:#ccf 1px solid'>\n";
//	$r .= " <img id='cathub-notify-me' src='$wgScriptPath/extensions/wikia/CategoryHubs/notify.png' width='114' height='74' style='float:right;padding:5px;'/>";
//	$r .= "</div>";

	// The actual title that will show up (since we hide the default).
	$r .= "<h1>".$catView->getCat()->getTitle()."</h1>";

	$allQuestions = categoryHubsProgressBar( CategoryEdits::newFromId($catView->getCat()->getId()), $r );

	$r .= "</div>\n";

	return $allQuestions;
} // end categoryHubTitleBar()


function categoryHubsProgressBar( $categoryEdits, &$r ) {

	$PROG_BAR_WIDTH = 250; // in pixels.  If this is changed, make sure to re-evaluate MIN_PERCENT_TO_SHOW_TEXT_ON_LEFT
	$MIN_PERCENT_TO_SHOW_TEXT = 11; // if cat is this percentage or more complete, the percentage will be shown in left side of progress bar.
	$MIN_PERCENT_TO_ADD_SPACE = 14; // adds a second non-breaking space before % answered if there is room for it (to make it look better).
	$r .= "<div style='display:table;width:$PROG_BAR_WIDTH"."px'>"; // wraps the progress bar and the labels below it
	$r .= "<div class='cathub-progbar-wrapper' style='width:$PROG_BAR_WIDTH"."px'>";

	$answeredCategory = CategoryHub::getAnsweredCategory();
	$unAnsweredCategory = CategoryHub::getUnAnsweredCategory();
	list($percentAnswered, $countAnswered, $countUnAnswered) = $categoryEdits->getPercentInCats($answeredCategory, $unAnsweredCategory);
	$allQuestions = $countAnswered + $countUnAnswered;
	if($percentAnswered <= 0){
		$percentAnswered = 0;
		$r .= "<div class='cathub-progbar-unanswered' style='width:$PROG_BAR_WIDTH'>".wfMsgExt('cathub-progbar-none-done', array())."</div>\n";
	} else if($percentAnswered >= 100){
		if ( empty($countUnAnswered) ) {
			$percentAnswered = 100;
			$r .= "<div class='cathub-progbar-answered' style='width:$PROG_BAR_WIDTH' title=''>".wfMsgExt('cathub-progbar-all-done', array())."</div>\n";
		} else {
			// some unanswered questions
			$r .= "<div class='cathub-progbar-answered' style='width:$PROG_BAR_WIDTH' title=''>".wfMsgExt('cathub-progbar-allmost-done', 'parsemag', $countUnAnswered)."</div>\n";
		}
	} else {
		// TODO: EXTRACT THIS TO A FUNCTION WHICH WILL MAKE A BANDWIDTH-EFFICIENT PROGRESS BAR FOR ANY USE (IF POSSIBLE TO DO CLEANLY... MIGHT HAVE TO REQUIRE IT TO BE ANSWERS-SPECIFIC).
		#$aPercent = substr($percentAnswered, 0, -1); // removes the "%" sign
		$aPercent = $percentAnswered;
		$uPercent = (100 - $percentAnswered);
		$aWidth = round(($PROG_BAR_WIDTH * $aPercent) / 100);
		$uWidth = $PROG_BAR_WIDTH - $aWidth;
		$aTitle = wfMsgExt('cathub-progbar-mouseover-answered', array(), $aPercent, $countAnswered);
		$uTitle = wfMsgExt('cathub-progbar-mouseover-not-answered', array(), $uPercent, $countUnAnswered);

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

	$r .= "<div class='cathub-progbar-label cathub-progbar-label-left'>".wfMsgExt('cathub-progbar-label-answered', array())."</div>";
	$r .= "<div class='cathub-progbar-label cathub-progbar-label-right'>".wfMsgExt('cathub-progbar-label-unanswered', array())."</div>";
	$r .= "</div>"; // close the wrapper on the div containing the progress bar and the labels.


	return $allQuestions;
}

function wfCategoryHubGetAnsweredQuestions( $answeredArticles, &$r, $type, $suffix, $numReturned_a, $offset_a, $parser = null, $inTag = false ) {
	global $wgUser, $wgCategoryHubArticleLimitPerTab;
	if( empty( $parser ) ) {
		$tmpParser = new Parser();
		$tmpParser->setOutputType(OT_HTML);
		$tmpParserOptions = new ParserOptions();
	} else {
		$inTag = true;
	}

	$r .= "<ul class='interactive-questions'>\n";
	foreach($answeredArticles as $qArticle) {
		if(is_object($qArticle)) {
			$r .= "<li class=\"$type\">\n";

			// Button to trigger the form for changing an answer inline.
			$r .= "<div class='cathub-button hideUntilHover'>\n";
			$r .= "<a rel='nofollow' class='bigButton cathub-button-answer' href='javascript:void(0)'><big>";
			$r .= wfMsgExt('cathub-button-improve-answer', array())."</big><small>&nbsp;</small></a>\n";
			$r .= "</div>\n";

			// Question & attribution for last edit.
			$title = $qArticle->getTitle();
			$r .= "<span class=\"$type cathub-article-link\">" . $wgUser->getSkin()->makeKnownLinkObj( $title, $title->getPrefixedText() . '?' ) . '</span>';
			// TODO: RESTORE THIS WHEN rephrase IS WORKING.
			//$r .= "&nbsp;<span class='cathub-button-rephrase hideUntilHover'><a href='javascript:void(0)'>".wfMsgExt('cathub-button-rephrase', array())."</a></span>";
			$r .= categoryHubGetAttributionByArticle($qArticle, true); //'true' uses messages for 'answered'

			// Show the  actual answer.
			$r .= "<div class='cathub-actual-answer'>";
			$r .= "<span class='cathub-answer-heading'>".wfMsgExt('cathub-answer-heading', array())."</span><br/>\n";

			$articleText = $qArticle->getRawText();
			// don't render the same tag which renders the list of articles etc. please
			$articleText = str_replace( '<answers_tabs/>', '', $articleText );
			$articleText = str_replace( '<answers_tabs />', '', $articleText );

			if( empty( $parser ) ) {
				$r .= $tmpParser->parse( $articleText, $title, $tmpParserOptions, false)->getText();
			} else {
				$r .= $parser->recursiveTagParse( $articleText );
			}
			$r .= "</div>\n";

			$r .= "</li>\n";
		}
	}
	$r .= "</ul>\n";

	if($numReturned_a > 0){
		$r .= categoryHubPagination($wgCategoryHubArticleLimitPerTab, $offset_a, $numReturned_a, $suffix, $inTag);
	}
}

function wfCategoryHubGetUnansweredQuestions( $unansweredArticles, &$r, $type, $suffix, $numReturned_u, $offset_u, $inTag = false ) {
	global $wgUser, $wgCategoryHubArticleLimitPerTab;
	// the plan is: load through js, and then do
	// ^_^  

	$r .= "<ul class='interactive-questions'>\n";

	foreach($unansweredArticles as $qArticle) {
		if(is_object($qArticle)) {
			$r .= "<li class=\"$type\">\n";

			// Button to trigger the form for answering inline.
			$r .= "<div class='cathub-button hideUntilHover'>\n";
			$r .= "<a rel='nofollow' class='bigButton cathub-button-answer' href='javascript:void(0)'><big>";
			$r .= wfMsgExt('cathub-button-answer', array())."</big><small>&nbsp;</small></a>\n";
			$r .= "</div>\n";

			// Question & attribution for last edit.
			$title = $qArticle->getTitle();
			$r .= "<span class=\"$type cathub-article-link\">" . $wgUser->getSkin()->makeKnownLinkObj( $title, $title->getPrefixedText() . '?' ) . '</span>';
			$r .= categoryHubGetAttributionByArticle($qArticle);

			$r .= "</li>\n";
		}
	}
	$r .= "</ul>\n";

	if($numReturned_u > 0){
		$r .= categoryHubPagination($wgCategoryHubArticleLimitPerTab, $offset_u, $numReturned_u, $suffix, $inTag);
	}
}

/*
*
*
*
*
*	$category Title
*/

function categoryHubRenderTabs( $category, $answeredArticles, $unansweredArticles, &$r, $parser = null ) {
	wfProfileIn(__METHOD__);
	global $wgCatHub_useDefaultView, $wgCategoryHubArticleLimitPerTab, $wgRequest;
	if(!$wgCatHub_useDefaultView){
		global $wgUser;
		$r .= "<div id='tabs'>\n"; // jquery ui tabs widget
		if( !empty( $parser ) ) {
			$r .= '<span id="tag-tabs">&nbsp;</span>';
		}
		$UN_CLASS = "unanswered_questions";
		$ANS_CLASS = "answered_questions";
		$U_SUFFIX = "_u"; // appended to url params to differentiate whihc tab is being paginated
		$A_SUFFIX = "_a";

		$offset_u = $wgRequest->getVal("offset$U_SUFFIX", 0);
		$offset_a = $wgRequest->getVal("offset$A_SUFFIX", 0);

		// Determine if there needs to be a "Next" button (ie: there are more items than the limit), then actually enforce the limit.
		if(empty($unansweredArticles)){
			$unansweredArticles = array();
		}
		if(empty($answeredArticles)){
			$answeredArticles = array();
		}
		$numReturned_u = count($unansweredArticles);
		$numReturned_a = count($answeredArticles);
		while(count($unansweredArticles) > $wgCategoryHubArticleLimitPerTab){
			array_pop($unansweredArticles);
		}
		while(count($answeredArticles) > $wgCategoryHubArticleLimitPerTab){
			array_pop($answeredArticles);
		}

		// Store info in the DOM on which tab to select (interactiveLists.js will apply this selection).
		$tabIndex = (($offset_a != 0) && ($offset_u == 0))?1:0; // if we are paginating Answered questions, select that tab.
		$r .= "<div id=\"cathub-tab-index-to-select\" style='display:none'>$tabIndex</div>\n";

		// The tabs.
		$r .= "<ul>\n";
		$r .= "<li><a href='#cathub-tab-unanswered' id=\"cathub-tablink-unanswered\"><span>".wfMsgExt('Unanswered_category', array())."</span></a></li>\n";
		$r .= "<li><a href='#cathub-tab-answered'   id=\"cathub-tablink-answered\"><span>".wfMsgExt('Answered_category', array())."</span></a></li>\n";
		$r .= "</ul>\n";

		// Unanswered questions in this category.
		$r .= "<div id=\"cathub-tab-unanswered\">\n";
		if(empty($unansweredArticles) || count($unansweredArticles) == 0){
			$r .= "<div class='no-questions-now'>";
			$r .= wfMsgExt('cathub-no-unanswered-questions', array());
			$r .= "</div>";
		} else {
			wfCategoryHubGetUnansweredQuestions( $unansweredArticles, &$r, $UN_CLASS, $U_SUFFIX, $numReturned_u, $offset_u );
		}

		$r .= "&nbsp;</div>\n";

		// Answered questions in this category.
		$r .= "<div id=\"cathub-tab-answered\">\n";
		if(empty($answeredArticles) || count($answeredArticles) == 0){
			$r .= "<div class='no-questions-now'>";
			$r .= wfMsgExt('cathub-no-answered-questions', array());
			$r .= "</div>";
		} else {
			wfCategoryHubGetAnsweredQuestions( $answeredArticles, &$r, $ANS_CLASS, $A_SUFFIX, $numReturned_a, $offset_a, $parser );
		}

		$r .= "&nbsp;</div>\n";

		$r .= "</div>\n"; // end of #tabs
	}

	wfProfileOut(__METHOD__);
	return $wgCatHub_useDefaultView;
}

function categoryHubGetLogo($cat_name) {
	$cat_name = str_replace("_", " ", $cat_name);

	// Fetch the icon for the corresponding wiki if there is one.
	WikiFactory::isUsed(true);

	$cityId = null;
	global $wgContLang;

	$key = "cathub-logo:{$cat_name}";
	if (!isMsgEmpty($key)) {
		$logoMsg = trim(wfMsg($key));

		if ("-" == $logoMsg) return "";

		if (preg_match("/^http:\/\/images\d?\.wikia\.(com|nocookie\.net)/", $logoMsg)) return htmlspecialchars($logoMsg);

		$cityId = WikiFactory::DomainToID($logoMsg);
	}

	if (empty($cityId)) {
		$cityId = WikiFactory::MultipleVarsToID(array("wgSitename" => $cat_name, "wgLanguageCode" => $wgContLang->getCode()));
	}
	if (empty($cityId)) {
		$cityId = WikiFactory::MultipleVarsToID(array("wgWidgetAnswersForceCategoryForAsk" => $cat_name, "wgLanguageCode" => $wgContLang->getCode()));
	}
	if (empty($cityId)) return "";

	$logoSrc = WikiFactory::getVarValueByName( 'wgLogo', $cityId );
	global $wgUploadPath;
	if(strpos($logoSrc, "wgUploadPath") !== false){
		$wikiUploadPath = WikiFactory::getVarValueByName( 'wgUploadPath', $cityId );
		$logoSrc = str_replace("\$wgUploadPath", $wikiUploadPath, $logoSrc);
	}

	return $logoSrc;
}

/**
 * Appends the top contributors of all time for this category as well as the top contributors
 * in the last X days (X == 7 initially, this may change) to the value of r.
 */
function categoryHubTopContributors(&$catView, &$r){
	$r .= "<div id='topContributorsWrapper'>\n";
	$r .= "<h2>".wfMsgExt('cathub-top-contributors', array())."</h2>";

	$categoryEdits = CategoryEdits::newFromId($catView->getCat()->getId());
	$NUM_CONTRIBS_PER_SECTION = 10;

	// Top Contributors for all time
	$show_staff = false;
	$r .= "<div id='topContribsAllTime'>\n";
	$r .= "<h3>".wfMsgExt('cathub-top-contribs-all-time', array())."</h3>";
	$r .= categoryHubContributorsToHtml($categoryEdits->getContribs($show_staff, $NUM_CONTRIBS_PER_SECTION));
	$r .= "</div>\n";

	// Recent Top Contributors
	$r .= "<div id='topContribsRecent'>\n";
	$r .= "<h3>".wfMsgExt('cathub-top-contribs-recent', 'parsemag', CATHUB_RECENT_CONTRIBS_LOOKBACK_DAYS)."</h3>";
	$r .= categoryHubContributorsToHtml($categoryEdits->getXDayContribs(CATHUB_RECENT_CONTRIBS_LOOKBACK_DAYS, $show_staff, $NUM_CONTRIBS_PER_SECTION));
	$r .= "</div>\n";

	$r .= "</div><div style='clear:both'>&nbsp;</div>\n"; // clearing div is for Chrome
} // end categoryHubTopContributors()

/**
 * Given an array of user ids mapped to and how many edits they've had in the valid lookback period for this category,
 * (as returned from CategoryEdits::getContribs or CategoryEdits::getXDayContribs, etc.), returns the HTML for an
 * ordered list of the users.
 */
function categoryHubContributorsToHtml( $editsByUserId ) {
	$r = '';
	$NUM_TO_SHOW_BIG = 3; // all beyond this will use the small text-only badge

	if( is_array ( $editsByUserId ) && count( $editsByUserId ) > 0 ) {
		$numShown = 0;

		$r .= Xml::openElement( 'ol', array( 'class' => 'contributors cathub-contributors-list cathub-contributors-list-wide' ) );

		foreach( $editsByUserId as $userId => $numEdits ) {
			if($numShown == $NUM_TO_SHOW_BIG){
				$r .= Xml::closeElement( 'ol' );
				$r .= Xml::openElement( 'ol',
						array(
							'start' => $NUM_TO_SHOW_BIG + 1,
							'class' => 'contributors cathub-contributors-list cathub-contributors-list-narrow userInfoNoAvatar'
						)
					);
			}
			$r .= Xml::openElement( 'li' );

			// TODO: Must find a way to get rid of these for Internet Explorer versions. (IE7/IE8)
			$r .= "<div class='listNumber".(($numShown >= $NUM_TO_SHOW_BIG)?" userInfoNoAvatar":"")."'>\n";
			$r .= ($numShown+1).".&nbsp;";
			$r .= "</div>";

			// Another <div> we probably don't need, right?
			$r .= Xml::openElement( 'div', array( 'class' => 'badgeWrapper' ) );

			$user = User::newFromId($userId);
			$userData['user_id'] = $userId;
			$userData['user_name'] = $user->getName();
			$userData['edits'] = Answer::getUserEditPoints($userId); // spec is to show total edit count, not current relevant numEdits.
			$r .= Answer::getUserBadge($userData, ($numShown < $NUM_TO_SHOW_BIG));

			$r .= Xml::closeElement( 'div' ); // END .badgeWrapper

			$r .= Xml::closeElement( 'li' );
			$numShown++;
		}
		$r .= Xml::closeElement( 'ol' );
	}

	return $r;
} // end categoryHubContriutorsToHtml()

/**
 * Appends the HTML to 'r' for the "other section" which for Category Hubs is
 * the Answered/Unanswered questions section, and the pagination.
 *
 * @see categoryHubPagination()
 */
function categoryHubOtherSection(&$catView, &$r){
	wfProfileIn(__METHOD__);

	$ret = categoryHubRenderTabs( $catView->title, $catView->answerArticles["answered_questions"], $catView->answerArticles["unanswered_questions"], $r);

	return $ret;

} // end categoryHubOtherSection()

/**
 * Pagination for category hub pages.
 *
 * Currently only outputs HTML.
 *
 * Called by categoryHubOtherSection()
 *
 * @param limit Int - the number of items allowed to appear in the current tab
 * @param offset Int - the index of the first question to display (also equal to the number of questions skipped).
 * @param numReturned Int - the number of questions returned by getPages.  If this is greater than the limit, we will know to use a Next link.
 * @param suffix String - a suffix to append to the offset.  This is needed since there are two pagination links
 *                        per page (one for each tab).
 */
function categoryHubPagination($limit, $offset, $numReturned, $suffix, $inTag = false) {
	$html = "";
	$html .= Xml::openElement('ul', array('class' => "cathub-pagination"));

	GLOBAL $wgUser,$wgTitle;
	$sk = $wgUser->getSkin();
	$html .= Xml::openElement('li', array('class' => "first"));
	if($offset > 0){
		if( $inTag ) {
			$html .= $sk->link( $wgTitle, wfMsgExt('cathub-prev', array()), array('id' => 'answers_tags_prev', 'rel' => 'previous'), array( "offset$suffix" => ($offset - $limit)), array('known'));
		} else {
			$html .= $sk->link( $wgTitle, wfMsgExt('cathub-prev', array()), array('rel' => 'previous'), array( "offset$suffix" => ($offset - $limit)), array('known'));
		}
	} else {
		$html .= "&nbsp;";
	}
	$html .= Xml::closeElement('li');

	$nextLink = "";
	$html .= Xml::openElement('li', array('class' => 'last'));
	if($numReturned > $limit){
		if( $inTag ) {
			$html .= $sk->link( $wgTitle, wfMsgExt('cathub-next', array()), array('id' => 'answers_tags_next', 'rel' => 'next'), array( "offset$suffix" => ($offset + $limit)), array('known'));
		} else {
			$html .= $sk->link( $wgTitle, wfMsgExt('cathub-next', array()), array('rel' => 'next'), array( "offset$suffix" => ($offset + $limit)), array('known'));
		}
	} else {
		$html .= "&nbsp;";
	}
	$html .= Xml::closeElement('li');

	$html .= Xml::closeElement('ul');
	return $html;
} // end categoryHubPagination()

/**
 * Appends the HTML to 'r' for the "other section" which for Category Hubs is
 * the Answered/Unanswered questions section.
 */
function categoryHubSubcategorySection(&$catView, &$r){
	global $wgCatHub_useDefaultView;
	if(!$wgCatHub_useDefaultView){

# Don't show subcategories section if there are none 
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

/**
 * Returns a string containing the HTML for the attribution line which can be used in
 * the answered/unanswered lists given an article.
 *
 * If 'answered' then the text will say "answered by" instead of "asked by".
 */
function categoryHubGetAttributionByArticle($qArticle, $answered=false){
	global $wgStylePath;
	$title = $qArticle->getTitle();
	$timestamp = $qArticle->getTimestamp();

	$userId = 0; $userLink = "";
	if ( empty($answered) ) {
		# get user who asked a question
		$author = CategoryHub::getTitleOwner($title);
	} else {
		# get user who answered a question
		$userName = $qArticle->getUserText();
		$userTitle = Title::makeTitle(NS_USER, $userName);
		$author = array( 
			"user_id" => $qArticle->getUser(),
			"user_name" => $userName,
			"title" => $userTitle,
			"avatar" => "",
			"ts" => $qArticle->getTimestamp()
		);
	}

	if ( is_array($author) ) {
		list( $userId, $userText, $userPageTitle, $userAvatar, $timestamp ) = array_values( $author );
	}
	$lastUpdate = wfTimeFormatAgo($timestamp);
	
	if($userId > 0){
		global $wgBlankImgUrl;
		$userPageLink = $userPageTitle->getLocalUrl();
		$userPageExists = $userPageTitle->exists();
		$userLinkText = $userPageExists ? '<a class="fe_user_icon" rel="nofollow" href="'.$userPageLink.'">' : '';
		$userLinkText .= "<img src='$wgBlankImgUrl' class='fe_user_img sprite' alt='".wfMsg('userpage')."' />";
		$userLinkText .= $userPageExists ? '</a>' : '';
		$userLinkText .= '<a rel="nofollow" class="fe_user_link'.($userPageExists ? '' : ' new').'" href="'.$userPageLink.'">'.$userText.'</a>';
		$userLink = wfMsgExt('cathub-question-asked-by', array(), $userLinkText);
	} else {
		$userLink = wfMsgExt('cathub-question-asked-by', array(), wfMsgExt('cathub-anon-username', array()));
	}
	if($answered){
		$asked = wfMsgExt('cathub-question-answered-ago', array(), $lastUpdate, $userLink);
	} else {
		$asked = wfMsgExt('cathub-question-asked-ago', array(), $lastUpdate, $userLink);
	}
	return "<div class='cathub-asked'>$asked</div>";
} // end categoryHubGetAttributionByArticle()


class CategoryHub {
	public function __construct( ) {}

	public static function getAnsweredCategory() {
		if ( class_exists("Answer") ) {
			$catName = Answer::getSpecialCategory("answered");
			$catName = str_replace(" ", "_", $catName);
		} else {
			$catName = "Answered_questions";
		}
		return $catName;
	}

	public static function getUnAnsweredCategory() {
		if ( class_exists("Answer") ) {
			$catName = Answer::getSpecialCategory("unanswered");
			$catName = str_replace(" ", "_", $catName);
		} else {
			$catName = "Un-answered_questions";
		}
		return $catName;
	}

	public static function getTitleOwner( Title $Title ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$author = array();
		if ( !($Title instanceof Title) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( class_exists("Answer") ) {
			$aTitle = Answer::newFromTitle($Title);
			if ( is_object($aTitle) ) {
				$author = $aTitle->getOriginalAuthor();
			}
		}

		if ( empty($author) ) {
			$pageId = $Title->getArticleID();
			$key = wfMemcKey( 'cathub_author', $pageId );
			$data = $wgMemc->get( $key );

			if ( empty($data) ) {
				$dbr =& wfGetDB( DB_SLAVE );

				$s = $dbr->selectRow(
					'revision',
					array( 'rev_user','rev_user_text', 'rev_timestamp' ),
					array( 'rev_page' => $pageId ),
					__METHOD__ ,
					array(
						'ORDER BY' => "rev_id  ASC",
						'LIMIT' => 1
					)
				);
				$user_title = Title::makeTitle(NS_USER,$s->rev_user_text);
				$author = array(
					"user_id" => $s->rev_user,
					"user_name" => $s->rev_user_text,
					"title" => $user_title,
					"avatar" => "",
					"ts" => $s->rev_timestamp
				);
				$wgMemc->set( $key, $author, 60 * 60 );
			} else {
				$author = $data;
			}
		}

		wfProfileOut( __METHOD__ );
		return $author;
	}

}

?>
