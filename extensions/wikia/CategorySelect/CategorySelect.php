<?php

/**
 * CategorySelect
 *
 * A CategorySelect extension for MediaWiki
 * Provides an interface for managing categories in article without editing whole article
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-01-13
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/CategorySelect/CategorySelect.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named CategorySelect.\n";
	exit(1) ;
}

$wgExtensionCredits['other'][] = array(
	'name' => 'CategorySelect',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'Provides an interface for managing categories in article without editing whole article.',
	'description-msg' => 'categoryselect-desc',
);

$wgExtensionFunctions[] = 'CategorySelectInit';
$wgExtensionMessagesFiles['CategorySelect'] = dirname(__FILE__) . '/CategorySelect.i18n.php';
$wgAutoloadClasses['CategorySelect'] = dirname(__FILE__) . '/CategorySelect_body.php';
$wgAjaxExportList[] = 'CategorySelectAjaxParseCategories';
$wgAjaxExportList[] = 'CategorySelectAjaxSaveCategories';
$wgAjaxExportList[] = 'CategorySelectGenerateHTMLforView';
$wgAjaxExportList[] = 'CategorySelectGetCategories';

/**
 * Initialize hooks - step 1/2
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectInit($forceInit = false) {
	global $wgRequest, $wgUser, $wgHooks;
	wfProfileIn(__METHOD__);

	if ($wgRequest->getVal('usecatsel','') == "no") {
		wfProfileOut(__METHOD__);
		return true;
	}

	if ( (!$forceInit) && (!$wgUser->isAllowed('edit')) ){
		wfProfileOut(__METHOD__);
		return true;
	}

	//don't use CategorySelect for undo edits
	$undoafter = $wgRequest->getVal('undoafter');
	$undo = $wgRequest->getVal('undo');
	$diff = $wgRequest->getVal('diff');
	$oldid = $wgRequest->getVal('oldid');
	$action = $wgRequest->getVal('action', 'view');
	if (($undo > 0 && $undoafter > 0) || $diff || ($oldid && $action != 'edit' && $action != 'submit')) {
		wfProfileOut(__METHOD__);
		return true;
	}

	$wgHooks['MediaWikiPerformAction'][] = 'CategorySelectInitializeHooks';
	$wgHooks['GetPreferences'][] = 'CategorySelectOnGetPreferences';

	wfProfileOut(__METHOD__);
}

/**
 * Initialize hooks - step 2/2
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectInitializeHooks($output, $article, $title, $user, $request, $mediawiki, $force = false ) {
	global $wgHooks, $wgRequest, $wgUser, $wgContentNamespaces;
	wfProfileIn(__METHOD__);

	// Check user preferences option
	if ($wgUser->getOption('disablecategoryselect') == true) {
		wfProfileOut(__METHOD__);
		return true;
	}

	// Initialize only for allowed skins
	$allowedSkins = array('SkinAnswers', 'SkinOasis');
	if ( !in_array( get_class(RequestContext::getMain()->getSkin()), $allowedSkins ) ) {
		wfProfileOut(__METHOD__);
		return true;
	}

	$action = $wgRequest->getVal('action', 'view');

	// Initialize only for namespace:
	// (a) content (on view)
	// (b) content, file, user, etc. (on edit)
	if (!$force) {
		if ( ( !in_array($title->mNamespace, array_merge( $wgContentNamespaces, array( NS_FILE, NS_CATEGORY, NS_VIDEO ) ) ) && ( $action == 'view' || $action == 'purge' ) )
			|| !in_array($title->mNamespace, array_merge( $wgContentNamespaces, array( NS_FILE, NS_USER, NS_CATEGORY, NS_VIDEO, NS_SPECIAL ) ) )
			|| ( $title->mNamespace == NS_TEMPLATE ) ) {
				wfProfileOut(__METHOD__);
			return true;
		}
	}

	// Don't initialize on CSS and JS user subpages
	if ( $title->isCssJsSubpage() ) {
		wfProfileOut(__METHOD__);
		return true;
	}

	// Don't initialize when user will see the source instead of the editor, see RT#25246
	if ( !$title->quickUserCan('edit') && ( NS_SPECIAL != $title->mNamespace ) ) {
		wfProfileOut(__METHOD__);
		return true;
	}

	if ($action == 'view' || $action == 'purge') {
		if ($title->mArticleID == 0) {
			wfProfileOut(__METHOD__);
			return true;
		}
		if ($action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted()) {
			wfProfileOut(__METHOD__);
			return true;
		}
		//view mode
		$wgHooks['Skin::getCategoryLinks::end'][] = 'CategorySelectGetCategoryLinksEnd';
		$wgHooks['Skin::getCategoryLinks::begin'][] = 'CategorySelectGetCategoryLinksBegin';
	} else if ($action == 'edit' || $action == 'submit' || $force) {
		//edit mode
		$wgHooks['EditPage::importFormData'][] = 'CategorySelectImportFormData';
		$wgHooks['EditPage::getContent::end'][] = 'CategorySelectReplaceContent';
		$wgHooks['EditPage::CategoryBox'][] = 'CategorySelectCategoryBox';
		$wgHooks['EditPage::showEditForm:fields'][] = 'CategorySelectAddFormFields';
		$wgHooks['EditPageGetDiffText'][] = 'CategorySelectDiffArticle';
		$wgHooks['EditForm::MultiEdit:Form'][] = 'CategorySelectDisplayCategoryBox';
		$wgHooks['MakeGlobalVariablesScript'][] = 'CategorySelectSetupVars';
	}

	wfProfileOut(__METHOD__);
	return true;
}

/**
 * Set variables for JS usage
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectSetupVars(Array &$vars) {
	/* @var $wgParser Parser */
	global $wgParser, $wgContLang;

	$vars['csAddCategoryButtonText'] = wfMsg('categoryselect-addcategory-button');
	$vars['csInfoboxCaption'] = wfMsg('categoryselect-infobox-caption');
	$vars['csInfoboxCategoryText'] = wfMsg('categoryselect-infobox-category');
	$vars['csInfoboxSortkeyText'] = wfMsg('categoryselect-infobox-sortkey');
	$vars['csInfoboxSave'] = wfMsg('save');
	$vars['csEmptyName'] = wfMsg('categoryselect-empty-name');
	$vars['csDefaultSort'] = $wgParser->getDefaultSort();
	$vars['csCategoryNamespaces'] = 'Category|' . $wgContLang->getNsText(NS_CATEGORY);
	$vars['csDefaultNamespace'] = $wgContLang->getNsText(NS_CATEGORY);
	$vars['csCodeView'] = wfMsg('categoryselect-code-view');
	$vars['csVisualView'] = wfMsg('categoryselect-visual-view');

	return true;
}

/**
 * Returns an array of all of the categories on the current wiki.  Used for
 * autocomplete.
 *
 * @author Inez Korczyński
 */
function CategorySelectGetCategories() {
	global $wgMemc, $wgRequest;
	wfProfileIn(__METHOD__);

	$key = wfMemcKey('CategorySelectGetCategories', 1);
	$out = $wgMemc->get($key);

	if (empty($out)) {
		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select(
			'category',
			'cat_title',
			array('cat_pages > 0'),
			__METHOD__,
			array('ORDER BY' => 'cat_pages DESC',
			      'LIMIT'    => '10000'));

		$categories = array();
		while($row = $dbr->fetchObject($res)) {
			$categories[] = str_replace('_', ' ', $row->cat_title);
		}

		$out = json_encode($categories);

		// Cache for a day
		// TODO: clear the cache when new category is added
		$wgMemc->set($key, $out, 86400);
	}

	// support JSON encoding
	$isJson = ($wgRequest->getVal('format') == 'json');
	if (!$isJson) {
		$out = 'var categoryArray = ' . $out;
	}

	$resp = new AjaxResponse($out);
	$resp->setCacheDuration(60 * 60);

	if ($isJson) {
		$resp->setContentType('application/json; charset=utf-8');
	}
	else {
		$resp->setContentType('application/javascript');
	}

	wfProfileOut(__METHOD__);
	return $resp;
}

/**
 * Parse categories via AJAX from wikitext to JSON
 * Return error on not handled syntax
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectAjaxParseCategories($wikitext) {
	$data = CategorySelect::SelectCategoryAPIgetData($wikitext);
	if (trim($data['wikitext']) == '') {	//all categories handled
		$result['categories'] = $data['categories'];
	} else {	//unhandled syntax
		$result['error'] = wfMsg('categoryselect-unhandled-syntax');
	}
	return json_encode($result);
}

/**
 * Save categories sent via AJAX into article
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectAjaxSaveCategories($articleId, $categories) {
	global $wgUser;

	if (wfReadOnly()) {
		$result['error'] = wfMsg('categoryselect-error-db-locked');
		return json_encode($result);
	}

	wfProfileIn(__METHOD__);

	Wikia::setVar('EditFromViewMode', 'CategorySelect');

	$categories = CategorySelectChangeFormat($categories, 'json', 'wiki');
	if ($categories == '') {
		$result['info'] = 'Nothing to add.';
	} else {
		$title = Title::newFromID($articleId);
		if (is_null($title)) {
			$result['error'] = wfMsg('categoryselect-error-not-exist', $articleId);
		} else {
			if ($title->userCan('edit') && !$wgUser->isBlocked()) {
				$result = null;
				$article = new Article($title);
				$article_text = $article->fetchContent();
				$article_text .= $categories;

				$dbw = wfGetDB( DB_MASTER );
				$dbw->begin();
				$editPage = new EditPage( $article );
				$editPage->edittime = $article->getTimestamp();
				$editPage->recreate = true;
				$editPage->textbox1 = $article_text;
				$editPage->summary = wfMsgForContent('categoryselect-edit-summary');
				$editPage->watchthis = $editPage->mTitle->userIsWatching();
				$bot = $wgUser->isAllowed('bot');
				$status = $editPage->internalAttemptSave( $result, $bot );
				$retval = $status->value;
				Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );

				switch($retval) {
					case EditPage::AS_SUCCESS_UPDATE:
					case EditPage::AS_SUCCESS_NEW_ARTICLE:
						$dbw->commit();
						$title->invalidateCache();
						Article::onArticleEdit($title);

						$skin = RequestContext::getMain()->getSkin();

						// return HTML with new categories
						// OutputPage::tryParserCache become deprecated in MW1.17 and removed in MW1.18 (BugId:30443)
						$parserOutput = ParserCache::singleton()->get( $article, $article->getParserOptions() );
						if ($parserOutput !== false) {
							$skin->getOutput()->addParserOutput($parserOutput);
						}

						$cats = $skin->getCategoryLinks();

						$result['info'] = 'ok';
						$result['html'] = $cats;
						break;

					case EditPage::AS_SPAM_ERROR:
						$dbw->rollback();
						$result['error'] = wfMsg('spamprotectiontext') . '<p>( Case #8 )</p>';
						break;

					default:
						$dbw->rollback();
						$result['error'] = wfMsg('categoryselect-edit-abort');
				}
			} else {
				$result['error'] = wfMsg('categoryselect-error-user-rights');
			}
		}
	}

	wfProfileOut(__METHOD__);
	return json_encode($result);
}

/**
 * Replace content of edited article [with cut out categories]
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectReplaceContent($editPage, &$text) {
	if (!$editPage->isConflict) {
		$data = CategorySelect::SelectCategoryAPIgetData($text);
		$text = $data['wikitext'];
	}
	return true;
}

/**
 * Remove hidden category box from edit page
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectCategoryBox( &$editform ) {
	// return false so that formatHiddenCategories will not be called
	return false;
}

/**
 * Change format of categories metadata
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectChangeFormat($categories, $from, $to) {
	if ($from == 'json') {
		$categories = $categories == '' ? array() : json_decode($categories, true);
	}

	if ($to == 'wiki') {
		$categoriesStr = '';
		if ( is_array($categories) && !empty($categories) ) {
			foreach($categories as $c) {
				if (empty($c)) continue;	//skip "null" keys created by JS
				$catTmp = "\n[[" . $c['namespace'] . ':' . $c['category'] . ($c['sortkey'] == '' ? '' : ('|' . $c['sortkey'])) . ']]';
				if ($c['outerTag'] != '') {
					$catTmp = '<' . $c['outerTag'] . '>' . $catTmp . '</' . $c['outerTag'] . '>';
				}
				$categoriesStr .= $catTmp;
			}
		}
		return $categoriesStr;
	} elseif ($to == 'array') {
		return $categories;
	}

	if ($from == 'array' && $to == 'json') {
		return json_encode($categories);
	}
}

/**
 * Add hidden field with category metadata
 *
 * @param EditPage $editPage
 * @param OutputPage $out
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectAddFormFields($editPage, $out) {
	global $wgCategorySelectMetaData;
	$categories = '';
	if (!empty($wgCategorySelectMetaData)) {
		$categories = htmlspecialchars(CategorySelectChangeFormat($wgCategorySelectMetaData['categories'], 'array', 'json'));
	}
	$out->addHTML("<input type=\"hidden\" value=\"$categories\" name=\"wpCategorySelectWikitext\" id=\"wpCategorySelectWikitext\" />");
	$out->addHTML('<input type="hidden" value="wiki" id="wpCategorySelectSourceType" name="wpCategorySelectSourceType" />');
	return true;
}

/**
 * Concatenate categories on EditPage POST
 *
 * @param EditPage $editPage
 * @param WebRequest $request
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 * @author Lucas Garczewski <tor@wikia-inc.com>
 */
function CategorySelectImportFormData($editPage, $request) {
	global $wgCategorySelectCategoriesInWikitext, $wgContLang, $wgEnableAnswers;

	if ($request->wasPosted()) {
		$sourceType = $request->getVal('wpCategorySelectSourceType');
		if ($sourceType == 'wiki') {
			$categories = "\n" . trim($editPage->safeUnicodeInput($request, 'csWikitext'));
		} else {	//json
			$categories = $editPage->safeUnicodeInput($request, 'wpCategorySelectWikitext');
			$categories = CategorySelectChangeFormat($categories, 'json', 'wiki');
			if (trim($categories) == '') {
				$categories = '';
			}
		}

		if ($editPage->preview || $editPage->diff) {
			$data = CategorySelect::SelectCategoryAPIgetData($editPage->textbox1 . $categories);
			$editPage->textbox1 = $data['wikitext'];
			$categories = CategorySelectChangeFormat($data['categories'], 'array', 'wiki');
		} else {	//saving article
			if ( !empty( $wgEnableAnswers ) ) {
				// don't add categories if the page is a redirect
				$magicWords = $wgContLang->getMagicWords();
				$redirects = $magicWords['redirect'];
				array_shift( $redirects ); // first element doesn't interest us
				// check for localized versions of #REDIRECT
				foreach ($redirects as $alias) {
					if ( stripos( $editPage->textbox1, $alias ) === 0 ) {
						return true;
					}
				}
			}

			// rtrim needed because of BugId:11238
			$editPage->textbox1 .= rtrim($categories);
		}
		$wgCategorySelectCategoriesInWikitext = $categories;
	}
	return true;
}

/**
 * Add categories to article for DiffEngine
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectDiffArticle($editPage, &$newtext) {
	global $wgCategorySelectCategoriesInWikitext;
	//add categories only for whole article editing
	if ($editPage->section == '' && isset($wgCategorySelectCategoriesInWikitext)) {
		$newtext .= $wgCategorySelectCategoriesInWikitext;
	}
	return true;
}

/**
 * Display category box on edit page
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectDisplayCategoryBox($rows, $cols, $ew, $textbox) {
	global $wgRequest, $wgOut;

	$action = $wgRequest->getVal('action', 'view');
	if ($action != 'view' && $action != 'purge') {
		CategorySelect::SelectCategoryAPIgetData($textbox);
		$wgOut->addHTML( CategorySelectGenerateHTMLforEdit('editform') );
	}
	return true;
}

/**
 * Remove regular category list under article (in edit mode)
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectGetCategoryLinksBegin(&$categoryLinks) {
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
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectGetCategoryLinksEnd(&$categoryLinks) {
	wfProfileIn(__METHOD__);
	global $wgRequest;

	if (!wfRunHooks ('CategorySelect:beforeDisplayingView', array () )) {
		wfProfileOut(__METHOD__);
		return false;
	}

	$action = $wgRequest->getVal('action', 'view');
	//for redirected page this hook is ran twice - check for button existence and don't add second one (fixes rt#12223)
	if (($action == 'view' || $action == 'purge') && strpos($categoryLinks, '<div id="csAddCategorySwitch"') === false) {
		global $wgBlankImgUrl;
		$categoryLinks .= ' <div id="csAddCategorySwitch" class="noprint" style="background:#DDD;position:relative;float:left;border: 1px solid #BBB;-moz-border-radius:3px;-webkit-border-radius:3px;padding:0 5px;line-height: 16px;"><img src="'.$wgBlankImgUrl.'" class="sprite-small add" /><a href="#" onfocus="this.blur();" style="color:#000;font-size:0.85em;text-decoration:none;display:inline-block;" rel="nofollow">' . wfMsg('categoryselect-addcategory-button') . '</a></div>';
	}

	wfProfileOut(__METHOD__);
	return true;
}

/**
 * Add required JS & CSS and return HTML [for 'edit article' mode]
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */

function CategorySelectGenerateHTMLforEditRaw($categories, $text = '') {

	$result = '<div class="csEditMode" id="csMainContainer"> ' . $text . '
			<input placeholder="'.wfMsg('categoryselect-addcategory-edit').'" data-placeholder="'.wfMsg('categoryselect-addcategory-edit').'" id="csCategoryInput" type="text" />
			<div id="csSuggestContainer">
				<div id="csHintContainer">' . wfMsg('categoryselect-suggest-hint') . '</div>
			</div>
			<div id="csItemsContainerDiv">
				<ul id="csItemsContainer">

				</ul>
			</div>
			<div id="csWikitextContainer"><textarea id="csWikitext" name="csWikitext" placeholder="'.wfMsg('categoryselect-code-view-placeholder').'" rows="4" data-initial-value="' . htmlspecialchars($categories) . '">' . htmlspecialchars($categories) . '</textarea></div>
			<div class="clearfix"></div>
		</div>';

	return $result;
}

function CategorySelectGenerateHTMLforEdit($formId = '') {
	global $wgOut, $wgExtensionsPath, $wgCategorySelectMetaData;

	$wgOut->addScript("<script type=\"text/javascript\">var formId = '$formId';</script>");
	$wgOut->addScript("<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/CategorySelect/CategorySelect.js\"></script>");

	// use SCSS file for Oasis
	if ( F::app()->checkSkin( 'oasis' ) ) {
		$cssFile = AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/CategorySelect/CategorySelect.scss');
	}
	else {
		$cssFile = "{$wgExtensionsPath}/wikia/CategorySelect/CategorySelect.css";
	}

	$wgOut->addExtensionStyle($cssFile);

	$categories = is_null($wgCategorySelectMetaData) ? '' : CategorySelectChangeFormat($wgCategorySelectMetaData['categories'], 'array', 'wiki');

	$text = "";
	wfRunHooks ('CategorySelect:beforeDisplayingEdit', array ( &$text ) ) ;

	return CategorySelectGenerateHTMLforEditRaw($categories, $text);
}

/**
 * Add required HTML and JS variables [for 'view article' mode]
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 * @author macbre
 */
function CategorySelectGenerateHTMLforView() {
	$html = '<div id="csMainContainer" class="csViewMode">
		<div id="csSuggestContainer">
			<div id="csHintContainer">' . wfMsg('categoryselect-suggest-hint') . '</div>
		</div>
		<div id="csItemsContainer" class="clearfix">
			<input id="csCategoryInput" type="text" style="display: none; outline: none;" />
		</div>
		<div id="csButtonsContainer" class="color1">
			<input type="button" id="csSave" onclick="csSave()" value="' . wfMsg('categoryselect-button-save') . '" />
			<input type="button" id="csCancel" onclick="csCancel()" value="' . wfMsg('categoryselect-button-cancel') . '" ' . ( ( F::app()->checkSkin( 'oasis' ) ) ? 'class="secondary" ' : '' ) . '/>
		</div>
	</div>';

	// lazy load global JS variables
	$vars = array();
	CategorySelectSetupVars($vars);

	$data = json_encode(array(
		'html' => $html,
		'vars' => $vars,
	));

	$ar = new AjaxResponse($data);
	$ar->setCacheDuration(60 * 60);
	$ar->setContentType('application/json; charset=utf-8');

	return $ar;
}

/**
 * Toggle CS in user preferences
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectOnGetPreferences($user, &$preferences) {
	global $wgEnableUserPreferencesV2Ext;
	if ($wgEnableUserPreferencesV2Ext) {
		$section = 'editing/starting-an-edit';
		$message = wfMsg('tog-disablecategoryselect-v2');
	}
	else {
		$section = 'editing/editing-experience';
		$message = wfMsg('tog-disablecategoryselect');
	}
	$preferences['disablecategoryselect'] = array(
		'type' => 'toggle',
		'section' => $section,
		'label' => $message,
	);
	return true;
}
