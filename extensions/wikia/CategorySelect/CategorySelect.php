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
	'description' => 'Provides an interface for managing categories in article without editing whole article.'
);

$wgExtensionFunctions[] = 'CategorySelectInit';
$wgExtensionMessagesFiles['CategorySelect'] = dirname(__FILE__) . '/CategorySelect.i18n.php';
$wgAjaxExportList[] = 'CategorySelectAjaxGetCategories';
$wgAjaxExportList[] = 'CategorySelectAjaxParseCategories';
$wgAjaxExportList[] = 'CategorySelectAjaxSaveCategories';
$wgAjaxExportList[] = 'CategorySelectRemoveTooltip';
$wgAjaxExportList[] = 'CategorySelectGenerateHTMLforView';

/**
 * Initialize hooks - step 1/2
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectInit() {
	global $wgRequest;

	//don't use CategorySelect for undo edits
	$undoafter = $wgRequest->getVal('undoafter');
	$undo = $wgRequest->getVal('undo');
	$diff = $wgRequest->getVal('diff');
	$oldid = $wgRequest->getVal('oldid');
	$action = $wgRequest->getVal('action', 'view');
	if (($undo > 0 && $undoafter > 0) || $diff || ($oldid && $action != 'edit' && $action != 'submit')) {
		return true;
	}

	global $wgHooks, $wgAutoloadClasses;
	$wgAutoloadClasses['CategorySelect'] = 'extensions/wikia/CategorySelect/CategorySelect_body.php';
	$wgHooks['ArticleFromTitle'][] = 'CategorySelectInitializeHooks';
	$wgHooks['UserToggles'][] = 'CategorySelectToggleUserPreference';
	$wgHooks['getEditingPreferencesTab'][] = 'CategorySelectToggleUserPreference';
}

/**
 * Initialize hooks - step 2/2
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectInitializeHooks($title, $article) {
	global $wgHooks, $wgRequest, $wgUser, $wgTitle;

	// Check user preferences option
	if($wgUser->getOption('disablecategoryselect') == true) {
		return true;
	}

	// Don't initialize for blocked users
	if($wgUser->isBlocked()) {
		return true;
	}

	// Initialize only for Monaco skin
	if(get_class($wgUser->getSkin()) != 'SkinMonaco') {
		return true;
	}

	// Initialize only for namespace: main, image, user (same as for Wysiwyg)
	if(!in_array($title->mNamespace, array(NS_MAIN, NS_IMAGE, NS_USER))) {
		return true;
	}

	// Don't initialize on CSS and JS user subpages
	if ( $wgTitle->isCssJsSubpage() ) {
		return true;
	}

	// Don't initialize when DB is locked
	if ( wfReadOnly() ) {
		return true;
	}

	$action = $wgRequest->getVal('action', 'view');

	if($action == 'view' || $action == 'purge') {
		if(!$title->exists()) {
			return true;
		}
		if ($action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted()) {
			return true;
		}
		if($wgTitle->userCan('edit')) {
			//view mode
			$wgHooks['Skin::getCategoryLinks::end'][] = 'CategorySelectGetCategoryLinksEnd';

			$wgHooks['Skin::getCategoryLinks::begin'][] = 'CategorySelectGetCategoryLinksBegin';
			$wgHooks['MakeGlobalVariablesScript'][] = 'CategorySelectSetupVars';
		}
	} else if($action == 'edit' || $action == 'submit') {
		//edit mode
		$wgHooks['EditPage::importFormData::finished'][] = 'CategorySelectImportFormData';
		$wgHooks['EditPage::getContent::end'][] = 'CategorySelectReplaceContent';
		$wgHooks['EditPage::CategoryBox'][] = 'CategorySelectCategoryBox';
		$wgHooks['EditPage::showEditForm:fields'][] = 'CategorySelectAddFormFields';
		$wgHooks['EditPage::showDiff::begin'][] = 'CategorySelectDiffArticle';
		$wgHooks['EditForm::MultiEdit:Form'][] = 'CategorySelectDisplayCategoryBox';

		$wgHooks['MakeGlobalVariablesScript'][] = 'CategorySelectSetupVars';
	}
	wfLoadExtensionMessages('CategorySelect');

	return true;
}

/**
 * Set variables for JS usage
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectSetupVars($vars) {
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
 * Get categories via AJAX that are matching typed text [for suggestion dropdown]
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectAjaxGetCategories() {
	global $wgRequest;
	$cat = $wgRequest->getText('query');

	$dbr = wfGetDB(DB_SLAVE);
	$res = $dbr->select(
		'category',
		'cat_title',
		'cat_title LIKE "%' . $dbr->escapeLike(str_replace(' ', '_', $cat)) . '%"',
		__METHOD__,
		array('LIMIT' => '10')
	);

	$categories = '';
	while($row = $dbr->fetchObject($res)) {
		$categories .= str_replace('_', ' ', $row->cat_title) . "\n";
	}

	$ar = new AjaxResponse($categories);
	$ar->setCacheDuration(60 * 20);

	return $ar;
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
		wfLoadExtensionMessages('CategorySelect');
		$result['error'] = wfMsg('categoryselect-unhandled-syntax');
	}
	return Wikia::json_encode($result);
}

/**
 * Save categories sent via AJAX into article
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectAjaxSaveCategories($articleId, $categories) {
	global $wgUser;
	$categories = CategorySelectChangeFormat($categories, 'json', 'wiki');
	if ($categories == '') {
		$result['info'] = 'Nothing to add.';
	} else {
		$title = Title::newFromID($articleId);
		if (is_null($title)) {
			$result['error'] = "Article [id=$articleId] does not exist.";
		} else {
			if($title->userCan('edit') && !$wgUser->isBlocked()) {
				global $wgOut;
				wfLoadExtensionMessages('CategorySelect');

				$article = new Article($title);
				$article_text = $article->fetchContent();
				$article_text .= $categories;
				$edit_summary = wfMsg('categoryselect-edit-summary');
				$flags = EDIT_UPDATE;
				$article->doEdit($article_text, $edit_summary, $flags);

				//return HTML with new categories
				$wgOut->tryParserCache($article, $wgUser);
				$sk = $wgUser->getSkin();
				$cats = $sk->getCategoryLinks();

				$result['info'] = 'ok';
				$result['html'] = $cats;
			} else {
				$result['error'] = "User rights error.";
			}
		}
	}
	return Wikia::json_encode($result);
}

/**
 * Replace content of edited article [with cutted out categories]
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectReplaceContent($editPage, $text) {
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
function CategorySelectCategoryBox($text) {
	$text = '';
	return true;
}

/**
 * Change format of categories metadata
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectChangeFormat($categories, $from, $to) {
	if ($from == 'json') {
		$categories = $categories == '' ? array() : Wikia::json_decode($categories, true);
	}

	if ($to == 'wiki') {
		$categoriesStr = '';
		foreach($categories as $c) {
			$catTmp = '[[' . $c['namespace'] . ':' . $c['category'] . ($c['sortkey'] == '' ? '' : ('|' . $c['sortkey'])) . ']]';
			if ($c['outerTag'] != '') {
				$catTmp = '<' . $c['outerTag'] . '>' . $catTmp . '</' . $c['outerTag'] . '>';
			}
			$categoriesStr .= $catTmp . "\n";
		}
		return "\n" . rtrim($categoriesStr);
	} elseif ($to == 'array') {
		return $categories;
	}

	if ($from == 'array' && $to == 'json') {
		return Wikia::json_encode($categories);
	}
}

/**
 * Add hidden field with category metadata
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectAddFormFields($editPage, $wgOut) {
	global $wgCategorySelectMetaData;
	$categories = '';
	if (!empty($wgCategorySelectMetaData)) {
		$categories = htmlspecialchars(CategorySelectChangeFormat($wgCategorySelectMetaData['categories'], 'array', 'json'));
	}
	$wgOut->addHTML("<input type=\"hidden\" value=\"$categories\" name=\"wpCategorySelectWikitext\" id=\"wpCategorySelectWikitext\" />");
	$wgOut->addHTML('<input type="hidden" value="wiki" id="wpCategorySelectSourceType" name="wpCategorySelectSourceType" />');
	return true;
}

/**
 * Concatenate categories on EditPage POST
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectImportFormData($editPage, $request) {
	global $wgCategorySelectCategoriesInWikitext;
	if ($request->wasPosted()) {
		$sourceType = $request->getVal('wpCategorySelectSourceType');
		if ($sourceType == 'wiki') {
			$categories = $editPage->safeUnicodeInput($request, 'csWikitext');
		} else {	//json
			$categories = $editPage->safeUnicodeInput($request, 'wpCategorySelectWikitext');
			$categories = CategorySelectChangeFormat($categories, 'json', 'wiki');
			if (trim($categories) == '') {
				$categories = '';
			}
		}

		if ($editPage->preview || $editPage->diff) {
			CategorySelect::SelectCategoryAPIgetData($categories);
		} else {	//saving article
			$editPage->textbox1 .= $categories;
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
function CategorySelectDiffArticle($editPage, $oldtext, $newtext) {
	global $wgCategorySelectCategoriesInWikitext;
	//add categories only for whole article editing
	if ($editPage->section == '' && isset($wgCategorySelectCategoriesInWikitext)) {
		$newtext .= "\n" . $wgCategorySelectCategoriesInWikitext;
	}
	return true;
}

/**
 * Display category box on edit page
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectDisplayCategoryBox($rows, $cols, $ew, $textbox) {
	global $wgCategorySelectMetaData, $wgRequest, $wgOut;

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
	global $wgRequest, $wgExtensionsPath;

	$action = $wgRequest->getVal('action', 'view');
	//for redirected page this hook is ran twice - check for button existence and don't add second one (fixes rt#12223)
	if (($action == 'view' || $action == 'purge') && strpos($categoryLinks, '<div id="csAddCategorySwitch"') === false) {
		$categoryLinks .= ' <div id="csAddCategorySwitch" style="position:relative;float:left;border: 1px solid #BBB;-moz-border-radius:3px;-webkit-border-radius:3px;padding:0 4px 0 12px;background:#ddd url(\'' . $wgExtensionsPath . '/wikia/CategorySelect/sprite.png\') left center no-repeat;line-height: 16px;"><a href="#" onclick="YAHOO.util.Get.script(wgExtensionsPath+\'/wikia/CategorySelect/CategorySelect.js?\'+wgStyleVersion,{onSuccess:function(){showCSpanel();}});$(\'catlinks\').className+=\' csLoading\';return false;" onfocus="this.blur();" style="color:#000;font-size:0.85em;text-decoration:none;background:#ddd;display:block;padding:0 3px">' . wfMsg('categoryselect-addcategory-button') . '</a></div>';
	}
	return true;
}

/**
 * Add required JS & CSS and return HTML [for 'edit article' mode]
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectGenerateHTMLforEdit($formId = '') {
	global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgCategorySelectMetaData;

	$wgOut->addScript("<script type=\"text/javascript\">var formId = '$formId';</script>");
	$wgOut->addScript("<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/CategorySelect/CategorySelect.js?$wgStyleVersion\"></script>");
	$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"$wgExtensionsPath/wikia/CategorySelect/CategorySelect.css?$wgStyleVersion\" />");

	$categories = is_null($wgCategorySelectMetaData) ? '' : CategorySelectChangeFormat($wgCategorySelectMetaData['categories'], 'array', 'wiki');
	$tooltip = CategorySelectAddTooltip();

	$result = '
	<script type="text/javascript">document.write(\'<style type="text/css">#csWikitextContainer {display: none}</style>\');</script>
	<div id="csMainContainer">
		' . $tooltip . '
		<div id="csSuggestContainer">
			<div id="csHintContainer">' . wfMsg('categoryselect-suggest-hint') . '</div>
		</div>
		<div id="csItemsContainer">
			<input id="csCategoryInput" type="text" style="display: none; outline: none;" />
		</div>
		<div id="csWikitextContainer"><textarea id="csWikitext" name="csWikitext">' . $categories . '</textarea></div>
		<div id="csSwitchViewContainer"><a id="csSwitchView" href="#" onclick="toggleCodeView(); return false;" onfocus="this.blur()" tabindex="-1">' . wfMsg('categoryselect-code-view') . '</a></div>
		<div class="clearfix"></div>
	</div>
	';

	return $result;
}

/**
 * Add required JS & CSS and return HTML [for 'view article' mode]
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectGenerateHTMLforView() {
	global $wgExtensionsPath, $wgStyleVersion;
	wfLoadExtensionMessages('CategorySelect');

	$result = '
	<div id="csMainContainer" class="csViewMode">
		<div id="csSuggestContainer">
			<div id="csHintContainer">' . wfMsg('categoryselect-suggest-hint') . '</div>
		</div>
		<div id="csItemsContainer" class="clearfix">
			<input id="csCategoryInput" type="text" style="display: none; outline: none;" />
		</div>
		<div id="csButtonsContainer" class="color1">
			<input type="button" id="csSave" onclick="csSave()" value="' . wfMsg('categoryselect-button-save') . '" />
			<input type="button" id="csCancel" onclick="csCancel()" value="' . wfMsg('categoryselect-button-cancel') . '" />
		</div>
	</div>
	';

	$ar = new AjaxResponse($result);
	$ar->setCacheDuration(60 * 60);

	return $ar;
}

/**
 * Add tooltip on first usage of Category Select
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
function CategorySelectAddTooltip() {

	// logic to check whether we should show tooltip
	global $wgUser;

	if ($wgUser->isAnon()) {
		// don't show for anon user
		$closed = true;
	}
	else {
		$closed = $wgUser->getOption('category-select-closed', 0) ? true : false;
	}

	return ($closed ? '' : '<div id="csTooltip">'.wfMsgExt('categoryselect-tooltip' , 'parse').'<span id="csTooltipClose">&nbsp;</span></div>');
}

/**
 * Permanently remove tooltip
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
function CategorySelectRemoveTooltip() {

	// store in user settings
	global $wgUser;

	if ($wgUser->isAnon()) {
		return;
	}

	$wgUser->setOption('category-select-closed', 1);
	$wgUser->saveSettings();

	// commit
	$dbw = wfGetDB( DB_MASTER );
	$dbw->commit();

	return new AjaxResponse('ok');
}

/**
 * Toggle CS in user preferences
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectToggleUserPreference($toggles, $default_array = false) {
	if(is_array($default_array)) {
		$default_array[] = 'disablecategoryselect';
	} else {
		$toggles[] = 'disablecategoryselect';
	}
	return true;
}
