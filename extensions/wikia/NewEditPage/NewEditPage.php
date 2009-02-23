<?
$wgExtensionCredits['other'][] = array(
        'name' => 'New Edit Page',
        'version' => 0.1,
        'author' => '[http://pl.wikia.com/wiki/User:Macbre Maciej Brencz]'
);

$wgExtensionFunctions[] = 'wfNewEditPageInit';

function wfNewEditPageInit() {
	global $wgHooks;

	// edit page
	$wgHooks['EditPage::showEditForm:initial2'][] = 'wfNewEditPageAddCSS';

	// not existing articles
	$wgHooks['ArticleFromTitle'][] = 'wfNewEditPageArticleView';
	return true;
}

function wfNewEditPageArticleView($title) {

	if (!$title->exists()) {
		wfNewEditPageAddCSS();
	}

	return $title;
}

function wfNewEditPageAddCSS() {
	global $wgWysiwygEdit, $wgOut, $wgExtensionsPath, $wgStyleVersion;

	// only change old MW edit page
	if (!empty($wgWysiwygEdit)) {
		return true;
	}

	// add static CSS file
	$wgOut->addLink(array(
		'rel' => 'stylesheet',
		'href' => "{$wgExtensionsPath}/wikia/NewEditPage/NewEditPage.css?{$wgStyleVersion}",
		'type' => 'text/css'
	));

	return true;
}
