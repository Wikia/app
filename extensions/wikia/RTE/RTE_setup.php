<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Rich Text Editor (Wysiwyg)',
	'description' => 'CKeditor integration for MediaWiki',
	'descriptionmsg' => 'rte-desc',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:New_editor',
	'author' => array('Inez Korczyński', 'Maciej Brencz')
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['RTE'] = "$dir/RTE.class.php";
$wgAutoloadClasses['RTEAjax'] = "$dir/RTEAjax.class.php";
$wgAutoloadClasses['RTEParser'] = "$dir/RTEParser.class.php";
$wgAutoloadClasses['RTEReverseParser'] = "$dir/RTEReverseParser.class.php";
$wgAutoloadClasses['RTELinker'] = "$dir/RTELinker.class.php";
$wgAutoloadClasses['RTEMarker'] = "$dir/RTEMarker.class.php";
$wgAutoloadClasses['RTEData'] = "$dir/RTEData.class.php";
$wgAutoloadClasses['RTEMagicWord'] = "$dir/RTEMagicWord.class.php";
$wgAutoloadClasses['RTELang'] = "$dir/RTELang.class.php";
$wgAutoloadClasses['CKEditor'] = "$dir/ckeditor/ckeditor_php5.php";

// hooks
$wgHooks['EditPage::showEditForm:initial'][] = 'RTE::init';
$wgHooks['ParserMakeImageParams'][] = 'RTEParser::makeImageParams';
$wgHooks['AlternateEdit'][] = 'RTE::reverse';
$wgHooks['EditPageBeforeConflictDiff'][] = 'RTE::reverse';

// hooks for user preferences handling
$wgHooks['getEditingPreferencesTab'][] = 'RTE::userPreferences';
$wgHooks['UserToggles'][] = 'RTE::userToggle';
$wgHooks['UserGetOption'][] = 'RTE::userGetOption';

// __NOWYSIWYG__ magic words handling
$wgHooks['MagicWordwgVariableIDs'][] = 'RTEMagicWord::register';
$wgHooks['LanguageGetMagic'][] = 'RTEMagicWord::get';
$wgHooks['InternalParseBeforeLinks'][] = 'RTEMagicWord::remove';
$wgHooks['ParserBeforeStrip'][] = 'RTEMagicWord::checkParserBeforeStrip';
$wgHooks['EditPage::getContent::end'][] = 'RTEMagicWord::checkEditPageContent';
//$wgHooks['Parser::FetchTemplateAndTitle'][] = 'RTEMagicWord::fetchTemplate'; # not called when doing RTE parsing

// i18n
$wgExtensionMessagesFiles['RTE'] = $dir.'/i18n/RTE.i18n.php';
$wgExtensionMessagesFiles['CKcore'] = $dir.'/i18n/CK.core.i18n.php';
$wgExtensionMessagesFiles['CKwikia'] = $dir.'/i18n/CK.wikia.i18n.php';

// enable MW suggest - this needs to be set here to make API calls working
$wgEnableMWSuggest = true;

// Ajax dispatcher
$wgAjaxExportList[] = 'RTEAjax';
function RTEAjax() {
	wfProfileIn(__METHOD__);
	global $wgRequest;

	$ret = false;

	$method = $wgRequest->getVal('method', false);

	if ($method && method_exists('RTEAjax', $method)) {
		wfLoadExtensionMessages('RTE');

		$data = RTEAjax::$method();

		if (is_array($data)) {
			$json = Wikia::json_encode($data);

			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
			$ret = $response;
		}
		else {
			$ret = $data;
		}
	}

	wfProfileOut(__METHOD__);
	return $ret;
}
