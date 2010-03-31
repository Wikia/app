<?php
/**
 * Lists
 *
 * This extension will allow easy creation and sharing of lists
 * either as an addition to an existing wiki or as a standalone wiki.
 * https://contractor.wikia-inc.com/wiki/Lists
 *
 * @author Sean Colombo <sean at wikia-inc dot com>
 * @date 20100330
 * @copyright Copyright (C) 2010 Sean Colombo, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/Lists/Lists.php");
 
 
// TODO: Extension which is a fork of the CategorySelect... to basically render the wikiText for a list differently.  It should only be called conditionally based on the namespace of the page.

// TODO: Add an extension which creates a box floated to the right which is a small vanity-box about the creator of the list & tells what other lists he/she has created

// TODO: extension for adding a right hand floated box of all of the watchers of the list (and avatar/user-badges of these ppl).

// TODO: Thumbs-up / Thumbs-down widget (rewrite the 5-stars extension in the process).   Thumbs-up adds to Watchlist in this version (thumbs-up and down should be hooks... or feedback in gen should be).

// TODO: "I like this" button (watchlist + 5 stars)

// TODO: Prominent "Start New List" button (if wgListsAsStandalone, then everywhere, else just on the namespace)

// TODO: Extension for sending an email to the list-creator any time someone watchlists the page (w/a user preference to disable this)

// TODO: Extension to change category page (only if it starts with wgListCategoryPrefix, etc. since it won't necessarily be for all categories)
	// TODO: Top users? Does this make sense in this context?
	// TODO: Possible iFrame for associated LyricWiki page
	// TODO: Top rated Lists
	// TODO: Most recent Lists

// TODO: Extension List render function has a hook call in addition to two default modes by wgListsAsStandalone
	// TODO: wgListsAsStandalone - category link and categorization
	// TODO: (!wgListsAsStandalone) - link to page with a small categorization link and a different categorization (Category:Lists Containing X).
 
 
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named 'Lists'.\n";
	exit(1) ;
}
 
define('NS_LISTS', 300);
define('NS_LISTS_TALK', 301);

$wgExtensionCredits['other'][] = array(
	'name' => 'Lists',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'url' => 'http://lyrics.wikia.com/User_talk:Sean_Colombo',
	'description' => 'Allows existing wikis or standalone wikis to easily create and share lists.',
	'description-msg' => 'lists-desc',
);

$wgExtensionFunctions[] = 'ListsInit';
$wgExtensionMessagesFiles['Lists'] = dirname(__FILE__) . '/Lists.i18n.php';

/**
 * Initialize auto-configured settings and set up the Lists extension.
 *
 * @author Sean Colombo
 */
function ListsInit() {
	global $wgUser;
	global $wgListsAsStandalone, $wgListsNamespace, $wgListsNamespace_talk, $wgListCategoryPrefix, $wgListItemCategoryPrefix;

	// Auto-configure some default settings based on whether this is a standalone wiki or not.
	if(!empty($wgListsAsStandalone)){
		$wgListsNamespace = (empty($wgListsNamespace)? NS_MAIN :$wgListsNamespace);
		$wgListsNamespace_talk = (empty($wgListsNamespace_talk)? NS_TALK :$wgListsNamespace_talk);
		$wgListCategoryPrefix = (empty($wgListCategoryPrefix)? "" :$wgListCategoryPrefix);
		$wgListItemCategoryPrefix = (empty($wgListItemCategoryPrefix)? "" :$wgListItemCategoryPrefix);
	} else {
		wfLoadExtensionMessages('Lists'); // needed for category and category item prefixes.
		$wgListsNamespace = (empty($wgListsNamespace)? NS_LISTS :$wgListsNamespace);
		$wgListsNamespace_talk = (empty($wgListsNamespace_talk)? NS_LISTS_TALK :$wgListsNamespace_talk);
		$wgListCategoryPrefix = (empty($wgListCategoryPrefix)? wfMsg('lists-default-category-prefix') :$wgListCategoryPrefix);
		$wgListItemCategoryPrefix = (empty($wgListItemCategoryPrefix)? wfMsg('lists-default-item-category-prefix') :$wgListItemCategoryPrefix);
	}
	// Use space, not underscore format for all comparisons in this extension.
	$wgListCategoryPrefix = str_replace("_", " ", $wgListCategoryPrefix);
	$wgListItemCategoryPrefix = str_replace("_", " ", $wgListItemCategoryPrefix);

	
	//don't use Lists for undo edits
	global $wgRequest;
	$undoafter = $wgRequest->getVal('undoafter');
	$undo = $wgRequest->getVal('undo');
	$diff = $wgRequest->getVal('diff');
	$oldid = $wgRequest->getVal('oldid');
	$action = $wgRequest->getVal('action', 'view');
	if (($undo > 0 && $undoafter > 0) || $diff || ($oldid && $action != 'edit' && $action != 'submit')) {
		return true;
	}

	global $wgHooks, $wgAutoloadClasses;
	$wgAutoloadClasses['ListExt'] = dirname(__FILE__)."/Lists.body.php";
	$wgHooks['MediaWikiPerformAction'][] = 'ListsInitializeHooks';
// TODO: REMOVE IF WE DON'T USE USER PREFERENCES.
//	$wgHooks['UserToggles'][] = 'CategorySelectToggleUserPreference';
//	$wgHooks['getEditingPreferencesTab'][] = 'CategorySelectToggleUserPreference';

	return true;
} // end ListsInit()

/**
 *
 */
function ListsInitializeHooks( $output, $article, $title, $user, $request, $wiki ){
	global $wgHooks, $wgRequest, $wgUser, $wgContentNamespaces;

	// Check user preferences option - NOTE: THIS USER OPTION DOESN'T EXIST YET... DO WE WANT IT?
	//if($wgUser->getOption('disablelistsextension') == true) {
	//	return true;
	//}

	$action = $wgRequest->getVal('action', 'view');

	// Initialize pieces of this extension (many of which are extensions of their own) based on what kind of page this is.
	if(ListExt::isThisPageAList()){
		// Initialize only for allowed skins
		$allowedSkins = array( 'SkinMonaco', 'SkinAnswers' );
		if( !in_array( get_class($wgUser->getSkin()), $allowedSkins ) ) {
			return true;
		}
		
		// Don't initialize when user will see the source instead of the editor, similar to CategorySelect with RT#25246
		if ( !$title->quickUserCan('edit') && ( NS_SPECIAL != $title->mNamespace ) ) {
			return true;
		}
		// Load the parts for editing conditionally on whether this user can edit.
		if( $wgUser->isAllowed('edit') ){
			if($action == 'view' || $action == 'purge') {
				if($title->mArticleID == 0) {
					return true;
				}
				if ($action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted()) {
					return true;
				}
				//view mode
// TODO: PORT THESE OVER
//				$wgHooks['Skin::getCategoryLinks::end'][] = 'CategorySelectGetCategoryLinksEnd';
//				$wgHooks['Skin::getCategoryLinks::begin'][] = 'CategorySelectGetCategoryLinksBegin';
//				$wgHooks['MakeGlobalVariablesScript'][] = 'CategorySelectSetupVars';
			} else if($action == 'edit' || $action == 'submit') {
				//edit mode
// TODO: PORT THESE OVER
//				$wgHooks['EditPage::importFormData::finished'][] = 'CategorySelectImportFormData';
//				$wgHooks['EditPage::getContent::end'][] = 'CategorySelectReplaceContent';
//				$wgHooks['EditPage::CategoryBox'][] = 'CategorySelectCategoryBox';
//				$wgHooks['EditPage::showEditForm:fields'][] = 'CategorySelectAddFormFields';
//				$wgHooks['EditPage::showDiff::begin'][] = 'CategorySelectDiffArticle';
//				$wgHooks['EditForm::MultiEdit:Form'][] = 'CategorySelectDisplayCategoryBox';

//				$wgHooks['MakeGlobalVariablesScript'][] = 'CategorySelectSetupVars';
			}
		}
	}
	if(ListExt::isThisPageAListCategory()){

		// TODO: LOAD THE EXTENSIONS OR PIECES OF EXTENSIONS THAT ARE USED ON CATEGORY PAGES.
		// TODO: LOAD THE EXTENSIONS OR PIECES OF EXTENSIONS THAT ARE USED ON CATEGORY PAGES.

	}
	wfLoadExtensionMessages('Lists');

	return true;
} // end ListsInitializeHooks()




/**
 * Remove regular category list under article (in view mode)
 */
function LinksGetCategoryLinksBegin(&$categoryLinks) {
	global $wgRequest, $wgOut;

	$action = $wgRequest->getVal('action', 'view');
	if (($action == 'view' || $action == 'purge') && count($wgOut->mCategoryLinks) == 0) {
		CategorySelectGetCategoryLinksEnd($categoryLinks);
		return false;
	}
	return true;
}

/**
 * Add 'add category' button next to category list under article (in view mode)
 *
 * @author Maciej Blaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectGetCategoryLinksEnd(&$categoryLinks) {
	global $wgRequest, $wgExtensionsPath, $wgOut, $wgStylePath;

	$action = $wgRequest->getVal('action', 'view');
	//for redirected page this hook is ran twice - check for button existence and don't add second one (fixes rt#12223)
	if (($action == 'view' || $action == 'purge') && strpos($categoryLinks, '<div id="csAddCategorySwitch"') === false) {
		global $wgBlankImgUrl;
		$categoryLinks .= ' <div id="csAddCategorySwitch" class="noprint" style="background:#DDD;position:relative;float:left;border: 1px solid #BBB;-moz-border-radius:3px;-webkit-border-radius:3px;padding:0 5px;line-height: 16px;"><img src="'.$wgBlankImgUrl.'" class="sprite-small add" /><a href="#" onfocus="this.blur();" style="color:#000;font-size:0.85em;text-decoration:none;display:inline-block;" rel="nofollow">' . wfMsg('categoryselect-addcategory-button') . '</a></div>';
		$wgOut->addInlineScript(<<<JS
/* CategorySelect */
wgAfterContentAndJS.push(function() {
	$(".catlinks-allhidden").css("display", "block");
	$('#csAddCategorySwitch').children('a').click(function() {
		WET.byStr('articleAction/addCategory');

		$.getScript(wgServer + wgScriptPath + '?action=ajax&rs=CategorySelectGetCategories');

		$.loadYUI( function() {
			$.getScript(wgExtensionsPath+ '/wikia/CategorySelect/CategorySelect.js?' + wgStyleVersion, function(){showCSpanel();});
		});

		$('#catlinks').addClass('csLoading');
		return false;
	});
});
JS
);
	}
	return true;
}




