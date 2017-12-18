<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Rich Text Editor (Wysiwyg)',
	'description' => 'CKeditor integration for MediaWiki',
	'descriptionmsg' => 'rte-desc',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:Editing',
	'author' => array('Inez Korczyński', 'Maciej Brencz')
);

// autoloaded classes
$wgAutoloadClasses['RTE'] = __DIR__ . '/RTE.class.php';
$wgAutoloadClasses['RTEAjax'] = __DIR__ . '/RTEAjax.class.php';
$wgAutoloadClasses['RTEData'] = __DIR__ . '/RTEData.class.php';
$wgAutoloadClasses['RTELang'] = __DIR__ . '/RTELang.class.php';
$wgAutoloadClasses['RTELinkerHooks'] = __DIR__ . '/RTELinkerHooks.class.php';
$wgAutoloadClasses['RTEMagicWord'] = __DIR__ . '/RTEMagicWord.class.php';
$wgAutoloadClasses['RTEMarker'] = __DIR__ . '/RTEMarker.class.php';
$wgAutoloadClasses['RTEParser'] = __DIR__ . '/RTEParser.class.php';
$wgAutoloadClasses['RTEReverseParser'] = __DIR__ . '/RTEReverseParser.class.php';
$wgAutoloadClasses['RTEController'] = __DIR__ . '/RTEController.class.php';

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
$wgExtensionMessagesFiles['RTE'] = __DIR__ . '/i18n/RTE.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'RTEAjax';
function RTEAjax() {
	wfProfileIn(__METHOD__);
	global $wgRequest;

	$ret = false;

	$method = $wgRequest->getVal( 'method', false );

	if ($method && method_exists( 'RTEAjax', $method )) {

		$data = RTEAjax::$method();

		if (is_array( $data )) {
			$json = json_encode( $data );

			$response = new AjaxResponse( $json );
			$response->setContentType( 'application/json; charset=utf-8' );
			$ret = $response;
		}
		else {
			$ret = $data;
		}
	}

	wfProfileOut(__METHOD__);
	return $ret;
}

JSMessages::registerPackage( 'rte-infobox-builder', [
	'rte-infobox',
	'rte-add-template',
	'rte-select-infobox-title',
	'rte-infobox-builder'
] );
JSMessages::enqueuePackage( 'rte-infobox-builder', JSMessages::EXTERNAL );
