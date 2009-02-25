<?
$wgExtensionCredits['other'][] = array(
        'name' => 'New Edit Page',
        'version' => 0.1,
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

	if (!$title->exists()) {
		wfNewEditPageAddCSS();
	}

	return $title;
}

// add CSS to edit pages
function wfNewEditPageAddCSS() {
	global $wgWysiwygEdit, $wgOut, $wgExtensionsPath, $wgStyleVersion;

	if (!empty($wgWysiwygEdit)) {
		$cssFile = 'NewEditPageWysiwyg.css';
	}
	else {
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
	global $wgOut;

	if ($editPage->formtype == 'preview') {
		wfLoadExtensionMessages('NewEditPage');
		$wgOut->addHTML('<div id="new_edit_page_preview_notice">' . wfMsg('new-edit-page-preview-notice') . '</div>');
	}

	return true;
}
