<?
$wgExtensionCredits['other'][] = array(
	'name' => 'New Edit Page',
	'description' => 'Applies edit page changes',
	'version' => 0.7,
	'author' => array('Maciej Brencz', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

$dir = dirname(__FILE__) . '/';

// register extension class
$wgAutoloadClasses['NewEditPage'] = $dir . 'NewEditPage.class.php';

// i18n
$wgExtensionMessagesFiles['NewEditPage'] = $dir . 'NewEditPage.i18n.php';

// add CSS for view / edit page
$wgHooks['EditPage::showEditForm:initial2'][] = 'NewEditPage::addCSS';

// handle not existing articles
$wgHooks['ArticleFromTitle'][] = 'NewEditPage::articleView';

// add red preview notice
$wgHooks['EditPage::showEditForm:initial'][] = 'NewEditPage::addPreviewBar';

// add brown old revision notice
$wgHooks['EditPage::showEditForm:oldRevisionNotice'][] = 'NewEditPage::addOldRevisionBar';

// undo success (RT #22732)
$wgHooks['EditPage::getContent::end'][] = 'NewEditPage::undoSuccess';

// shorten edit page 'transcluded pages' list using JS (RT #22760)
$wgHooks['LinkerFormatTemplates'][] = 'NewEditPage::formatTemplates';
