<?
$wgExtensionCredits['other'][] = array(
        'name' => 'New Edit Page',
	'description' => 'Applies edit page changes',
        'version' => 0.22,
        'author' => '[http://pl.wikia.com/wiki/User:Macbre Maciej Brencz]'
);

$wgExtensionFunctions[] = 'wfNewEditPageInit';

function wfNewEditPageInit() {
	global $wgHooks, $wgExtensionMessagesFiles;

	// i18n
	$wgExtensionMessagesFiles['NewEditPage'] = dirname(__FILE__).'/NewEditPage.i18n.php';

	// edit page
	$wgHooks['EditPage::showEditForm:initial2'][] = 'wfNewEditPageAddCSS';

	// not existing articles
	$wgHooks['ArticleFromTitle'][] = 'wfNewEditPageArticleView';

	// add red preview notice
	$wgHooks['EditPage::showEditForm:initial'][] = 'wfNewEditPageAddPreviewBar';
	return true;
}

// add custom CSS to page of not existing articles
function wfNewEditPageArticleView($title) {

	global $wgNewEditPageNewArticle, $wgRequest;

	// limit to not existing articles and view mode
	if (!$title->exists() && $wgRequest->getVal('action', 'view') == 'view') {
		$wgNewEditPageNewArticle = true;
		wfNewEditPageAddCSS();
	}

	return $title;
}

// add CSS to edit pages
function wfNewEditPageAddCSS() {
	global $wgWysiwygEdit, $wgOut, $wgUser, $wgExtensionsPath, $wgStyleVersion, $wgNewEditPageNewArticle;

	// do not touch skins other than Monaco (RT #13061)
	$skinName = get_class($wgUser->getSkin());
	if ($skinName != 'SkinMonaco') {
		return true;
	}

	if (!empty($wgNewEditPageNewArticle)) {
		// new article notice
		$cssFile = 'NewEditPageNewArticle.css';
	}
	else if (!empty($wgWysiwygEdit)) {
		// edit mode in wysiwyg
		$cssFile = 'NewEditPageWysiwyg.css';
	}
	else {
		// edit mode in old MW editor
		$cssFile = 'NewEditPage.css';
	}

	// add static CSS file
	$wgOut->addLink(array(
		'rel' => 'stylesheet',
		'href' => "{$wgExtensionsPath}/wikia/NewEditPage/{$cssFile}?{$wgStyleVersion}",
		'type' => 'text/css'
	));

	return true;
}

// add red preview notice in old editor
function wfNewEditPageAddPreviewBar($editPage) {
	global $wgOut, $wgUser, $wgHooks, $wgRequest;

	// do not touch skins other than Monaco (RT #13061)
	$skinName = get_class($wgUser->getSkin());
	if ($skinName != 'SkinMonaco') {
		return true;
	}

	// we're in preview mode
	// extra check for categories - they formtype always set to 'preview' (rt#15017)
	if ($editPage->formtype == 'preview' && !($editPage->mTitle->mNamespace == NS_CATEGORY && ($wgRequest->getVal('action') != 'submit' || !$wgRequest->wasPosted()))) {
		wfLoadExtensionMessages('NewEditPage');
		$wgOut->addHTML('<div id="new_edit_page_preview_notice">' . wfMsg('new-edit-page-preview-notice') . '</div>');

		// add page title before preview HTML
		$wgHooks['OutputPageBeforeHTML'][] = 'wfNewEditPageAddPreviewTitle';

		// hide page title in preview mode
		$wgOut->addHTML('<style type="text/css">.firstHeading {display: none}</style>');
	}

	return true;
}

// add page title before preview HTML
function wfNewEditPageAddPreviewTitle($wgOut, $text) {
	global $wgTitle;
	$wgOut->addHTML('<h1 id="new_edit_page_preview_title">' . $wgTitle->getPrefixedText() . '</h1>');

	// find first closing </h2> and remove preview notice
	$pos = strpos($text, '</h2>');
	if ($pos !== false) {
		$text = substr($text, $pos+5);
	}

	return true;
}
