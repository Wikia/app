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
	global $wgRequest, $wgUser;

	if( (!$forceInit) && (!$wgUser->isAllowed('edit')) ){
		return true;
	}

	//don't use CategorySelect for undo edits
	$undoafter = $wgRequest->getVal('undoafter');
	$undo = $wgRequest->getVal('undo');
	$diff = $wgRequest->getVal('diff');
	$oldid = $wgRequest->getVal('oldid');
	$action = $wgRequest->getVal('action', 'view');
	if (($undo > 0 && $undoafter > 0) || $diff || ($oldid && $action != 'edit' && $action != 'submit')) {
		return true;
	}

	global $IP, $wgHooks, $wgAutoloadClasses;
	$wgAutoloadClasses['CategorySelect'] = "$IP/extensions/wikia/CategorySelect/CategorySelect_body.php";
	$wgHooks['MediaWikiPerformAction'][] = 'CategorySelectInitializeHooks';
	$wgHooks['UserToggles'][] = 'CategorySelectToggleUserPreference';
	$wgHooks['getEditingPreferencesTab'][] = 'CategorySelectToggleUserPreference';
}

/**
 * Initialize hooks - step 2/2
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectInitializeHooks($output, $article, $title, $user, $request) {
	global $wgHooks, $wgRequest, $wgUser, $wgContentNamespaces;

	// Check user preferences option
	if($wgUser->getOption('disablecategoryselect') == true) {
		return true;
	}

	// Initialize only for allowed skins
	$allowedSkins = array( 'SkinMonaco', 'SkinAwesome', 'SkinAnswers' );
	if( !in_array( get_class($wgUser->getSkin()), $allowedSkins ) ) {
		return true;
	}

	// Initialize only for namespace: content, file, user (same as for Wysiwyg)
	if(!in_array($title->mNamespace, $wgContentNamespaces) && !in_array($title->mNamespace, array( NS_FILE, NS_USER, NS_CATEGORY, NS_VIDEO, NS_SPECIAL ))) {
		return true;
	}

	// Don't initialize on CSS and JS user subpages
	if ( $title->isCssJsSubpage() ) {
		return true;
	}

	// Don't initialize when user will see the source instead of the editor, see RT#25246
	if ( !$title->quickUserCan('edit') && ( NS_SPECIAL != $title->mNamespace ) ) {
		return true;
	}

	$action = $wgRequest->getVal('action', 'view');

	if($action == 'view' || $action == 'purge') {
		if($title->mArticleID == 0) {
			return true;
		}
		if ($action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted()) {
			return true;
		}
		//view mode
		$wgHooks['Skin::getCategoryLinks::end'][] = 'CategorySelectGetCategoryLinksEnd';
		$wgHooks['Skin::getCategoryLinks::begin'][] = 'CategorySelectGetCategoryLinksBegin';
		$wgHooks['MakeGlobalVariablesScript'][] = 'CategorySelectSetupVars';
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
 * @author Inez Korczyński
 */
function CategorySelectGetCategories($inline = false) {
	$dbr = wfGetDB(DB_SLAVE);
	$res = $dbr->select(
		'category',
		'cat_title',
		array('cat_pages > 0'),
		__METHOD__
	);
	$categories = array();
	while($row = $dbr->fetchObject($res)) {
		$categories[] = str_replace('_', ' ', addslashes($row->cat_title));
	}
	$out = 'var categoryArray = ["'.join('","', $categories).'"];';

	if($inline === true) {
		return $out;
	} else {
		$ar = new AjaxResponse($out);
		$ar->setCacheDuration(60 * 60);
		return $ar;
	}
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
	global $wgUser, $wgRequest;

	if (wfReadOnly()) {
		wfLoadExtensionMessages('CategorySelect');
		$result['error'] = wfMsg('categoryselect-error-db-locked');
		return Wikia::json_encode($result);
	}

	Wikia::setVar('EditFromViewMode', true);

	$categories = CategorySelectChangeFormat($categories, 'json', 'wiki');
	if ($categories == '') {
		$result['info'] = 'Nothing to add.';
	} else {
		wfLoadExtensionMessages('CategorySelect');
		$title = Title::newFromID($articleId);
		if (is_null($title)) {
			$result['error'] = wfMsg('categoryselect-error-not-exist', $articleId);
		} else {
			if($title->userCan('edit') && !$wgUser->isBlocked()) {
				global $wgOut;

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
				$bot = $wgUser->isAllowed('bot');
				$retval = $editPage->internalAttemptSave( $result, $bot );
				Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );
				if ( $retval == EditPage::AS_SUCCESS_UPDATE || $retval == EditPage::AS_SUCCESS_NEW_ARTICLE ) {
					$dbw->commit();
					$title->invalidateCache();
					Article::onArticleEdit($title);

					//return HTML with new categories
					$wgOut->tryParserCache($article, $wgUser);
					$sk = $wgUser->getSkin();
					$cats = $sk->getCategoryLinks();
					$result['info'] = 'ok';
					$result['html'] = $cats;
				} elseif ( $retval == EditPage::AS_SPAM_ERROR ) {
					$dbw->rollback();
					$result['error'] = wfMsg('spamprotectiontext');
				} else {
					$dbw->rollback();
					$result['error'] = wfMsg('categoryselect-edit-abort');	
				}
			} else {
				$result['error'] = wfMsg('categoryselect-error-user-rights');
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
		if ( is_array($categories) && !empty($categories) ) {
			foreach($categories as $c) {
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
	global $wgRequest, $wgExtensionsPath, $wgOut, $wgStylePath;

	$action = $wgRequest->getVal('action', 'view');
	//for redirected page this hook is ran twice - check for button existence and don't add second one (fixes rt#12223)
	if (($action == 'view' || $action == 'purge') && strpos($categoryLinks, '<div id="csAddCategorySwitch"') === false) {
		global $wgBlankImgUrl;
		$categoryLinks .= ' <div id="csAddCategorySwitch" class="noprint" style="background:#DDD;position:relative;float:left;border: 1px solid #BBB;-moz-border-radius:3px;-webkit-border-radius:3px;padding:0 5px;line-height: 16px;"><img src="'.$wgBlankImgUrl.'" class="sprite-small add" /><a href="#" onfocus="this.blur();" style="color:#000;font-size:0.85em;text-decoration:none;display:inline-block;" rel="nofollow">' . wfMsg('categoryselect-addcategory-button') . '</a></div>';

		// TODO: REMOVE THE loadYUI wrapper around the .getScript call after YUI is removed.
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

/**
 * Add required JS & CSS and return HTML [for 'edit article' mode]
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CategorySelectGenerateHTMLforEdit($formId = '') {
	global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgCategorySelectMetaData;

	$wgOut->addScript("<script type=\"text/javascript\">var formId = '$formId';".CategorySelectGetCategories(true)."</script>");
	$wgOut->addScript("<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/CategorySelect/CategorySelect.js?$wgStyleVersion\"></script>");
	$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"$wgExtensionsPath/wikia/CategorySelect/CategorySelect.css?$wgStyleVersion\" />");

	$categories = is_null($wgCategorySelectMetaData) ? '' : CategorySelectChangeFormat($wgCategorySelectMetaData['categories'], 'array', 'wiki');

	$result = '
	<script type="text/javascript">document.write(\'<style type="text/css">#csWikitextContainer {display: none}</style>\');</script>
	<div id="csMainContainer">
		<div id="csSuggestContainer">
			<div id="csHintContainer">' . wfMsg('categoryselect-suggest-hint') . '</div>
		</div>
		<div id="csItemsContainer">
			<input id="csCategoryInput" type="text" style="display: none; outline: none;" />
		</div>
		<div id="csWikitextContainer"><textarea id="csWikitext" name="csWikitext">' . $categories . '</textarea></div>
		<div id="csSwitchViewContainer"><a id="csSwitchView" href="#" onclick="toggleCodeView(); return false;" onfocus="this.blur()" tabindex="-1" rel="nofollow">' . wfMsg('categoryselect-code-view') . '</a></div>
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
			<input type="button" id="csSave" onclick="WET.byStr(\'articleAction/saveCategory\');csSave()" value="' . wfMsg('categoryselect-button-save') . '" />
			<input type="button" id="csCancel" onclick="WET.byStr(\'articleAction/cancelCategory\');csCancel()" value="' . wfMsg('categoryselect-button-cancel') . '" />
		</div>
	</div>
	';

	$ar = new AjaxResponse($result);
	$ar->setCacheDuration(60 * 60);

	return $ar;
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
