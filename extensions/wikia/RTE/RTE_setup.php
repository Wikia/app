<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Rich Text Editor (Wysiwyg)',
	'description' => 'CKeditor integration for MediaWiki',
	'descriptionmsg' => 'rte-desc',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:Editing',
	'author' => array('Inez Korczyński', 'Maciej Brencz')
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['RTE'] = "$dir/RTE.class.php";
$wgAutoloadClasses['RTEAjax'] = "$dir/RTEAjax.class.php";
$wgAutoloadClasses['RTEData'] = "$dir/RTEData.class.php";
$wgAutoloadClasses['RTELang'] = "$dir/RTELang.class.php";
$wgAutoloadClasses['RTELinkerHooks'] = "$dir/RTELinkerHooks.class.php";
$wgAutoloadClasses['RTEMagicWord'] = "$dir/RTEMagicWord.class.php";
$wgAutoloadClasses['RTEMarker'] = "$dir/RTEMarker.class.php";
$wgAutoloadClasses['RTEParser'] = "$dir/RTEParser.class.php";
$wgAutoloadClasses['RTEReverseParser'] = "$dir/RTEReverseParser.class.php";
$wgAutoloadClasses['RTEController'] = "$dir/RTEController.class.php";

// hooks
$wgHooks['EditPage::showEditForm:initial'][] = 'RTE::init';
$wgHooks['ParserMakeImageParams'][] = 'RTEParser::makeImageParams';
$wgHooks['AlternateEdit'][] = 'RTE::reverse';
$wgHooks['EditPageBeforeConflictDiff'][] = 'RTE::reverse';

// hooks for user preferences handling
$wgHooks['EditingPreferencesBefore'][] = 'RTE::onEditingPreferencesBefore';
$wgHooks['UserGetOption'][] = 'RTE::userGetOption';
$wgHooks['UserGetPreference'][] = 'RTE::userGetOption';

// __NOWYSIWYG__ magic words handling
$wgHooks['MagicWordwgVariableIDs'][] = 'RTEMagicWord::register';
$wgHooks['LanguageGetMagic'][] = 'RTEMagicWord::get';
$wgHooks['InternalParseBeforeLinks'][] = 'RTEMagicWord::remove';
$wgHooks['ParserBeforeStrip'][] = 'RTEMagicWord::checkParserBeforeStrip';
$wgHooks['EditPage::getContent::end'][] = 'RTEMagicWord::checkEditPageContent';

// hooks for modifying MW Linker behavior
$wgHooks['MakeHeadline'][] = 'RTELinkerHooks::onMakeHeadline';
$wgHooks['LinkEnd'][] = 'RTELinkerHooks::onLinkEnd';
$wgHooks['LinkerMakeExternalLink'][] = 'RTELinkerHooks::onLinkerMakeExternalLink';

// i18n
$wgExtensionMessagesFiles['RTE'] = $dir.'/i18n/RTE.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'RTEAjax';
function RTEAjax() {
	wfProfileIn(__METHOD__);
	global $wgRequest;

	$ret = false;

	$method = $wgRequest->getVal('method', false);

	if ($method && method_exists('RTEAjax', $method)) {

		$data = RTEAjax::$method();

		if (is_array($data)) {
			$json = json_encode($data);

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
