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

$wgResourceModules['ext.wikia.RTE2'] = array(
	'messages' => array(
		'rte-ck-bucket-textAppearance',
		'rte-ck-bucket-insert',
		'rte-ck-bucket-controls',
		'rte-ck-commentEditor-title',
		'rte-ck-errorPopupTitle',
		'rte-ck-hoverPreview-codedElement-intro',
		'rte-ck-hoverPreview-codedElement-title',
		'rte-ck-hoverPreview-comment-intro',
		'rte-ck-hoverPreview-comment-title',
		'rte-ck-hoverPreview-confirmDelete',
		'rte-ck-hoverPreview-delete',
		'rte-ck-hoverPreview-edit',
		'rte-ck-hoverPreview-media-notExisting',
		'rte-ck-hoverPreview-template-intro',
		'rte-ck-hoverPreview-template-notExisting',
		'rte-ck-hoverPreview-video-notExisting',
		'rte-ck-image-add',
		'rte-ck-image-photo',
		'rte-ck-image-confirmDelete',
		'rte-ck-image-confirmDeleteTitle',
		'rte-ck-imagePlaceholder-confirmDelete',
		'rte-ck-imagePlaceholder-confirmDeleteTitle',
		'rte-ck-imagePlaceholder-tooltip',
		'rte-ck-justify-center',
		'rte-ck-link-add',
		'rte-ck-link-error-badPageTitle',
		'rte-ck-link-error-badUrl',
		'rte-ck-link-error-title',
		'rte-ck-link-external-linkText',
		'rte-ck-link-external-numberedLink',
		'rte-ck-link-external-tab',
		'rte-ck-link-external-url',
		'rte-ck-link-internal-linkText',
		'rte-ck-link-internal-pageName',
		'rte-ck-link-internal-tab',
		'rte-ck-link-title',
		'rte-ck-link-label-target',
		'rte-ck-link-label-display',
		'rte-ck-link-label-internal',
		'rte-ck-link-label-external',
		'rte-ck-link-status-checking',
		'rte-ck-link-status-exists',
		'rte-ck-link-status-notexists',
		'rte-ck-link-status-external',
		'rte-ck-media-delete',
		'rte-ck-media-edit',
		'rte-ck-modeSwitch-toSource',
		'rte-ck-modeSwitch-toWysiwyg',
		'rte-ck-modeSwitch-toSourceTooltip',
		'rte-ck-modeSwitch-toWysiwygTooltip',
		'rte-ck-modeSwitch-error',
		'rte-ck-photoGallery-gallery',
		'rte-ck-photoGallery-slideshow',
		'rte-ck-photoGallery-slider',
		'rte-ck-photoGallery-addGallery',
		'rte-ck-photoGallery-addSlideshow',
		'rte-ck-photoGallery-addSlider',
		'rte-ck-photoGallery-confirmDelete',
		'rte-ck-photoGallery-confirmDeleteTitle',
		'rte-ck-photoGallery-tooltip',
		'rte-ck-photoGallery-tooltipSlideshow',
		'rte-ck-photoGallery-tooltipSlider',
		'rte-ck-signature-add',
		'rte-ck-signature-label',
		'rte-ck-table-alignNotSet',
		'rte-ck-table-invalidCols',
		'rte-ck-table-invalidRows',
		'rte-ck-table-toolbarTooltip',
		'rte-ck-templateDropDown-chooseAnotherTpl',
		'rte-ck-templateDropDown-showUsedList',
		'rte-ck-templateDropDown-makeLayout',
		'rte-ck-templateDropDown-label',
		'rte-ck-templateDropDown-title',
		'rte-ck-templateEditor-dialog-browse',
		'rte-ck-templateEditor-dialog-insert',
		'rte-ck-templateEditor-dialog-magicWords',
		'rte-ck-templateEditor-dialog-magicWordsLink',
		'rte-ck-templateEditor-dialog-mostFrequentlyUsed',
		'rte-ck-templateEditor-dialog-search',
		'rte-ck-templateEditor-editor-chooseAnotherTpl',
		'rte-ck-templateEditor-editor-intro',
		'rte-ck-templateEditor-editor-parameters',
		'rte-ck-templateEditor-editor-previewButton',
		'rte-ck-templateEditor-editor-previewTitle',
		'rte-ck-templateEditor-editor-viewTemplate',
		'rte-ck-templateEditor-usedTemplates-title',
		'rte-ck-templateEditor-title',
		'rte-ck-unlink',
		'rte-ck-video-add',
		'rte-ck-video-video',
		'rte-ck-video-confirmDelete',
		'rte-ck-video-confirmDeleteTitle',
		'rte-ck-videoPlaceholder-confirmDelete',
		'rte-ck-videoPlaceholder-confirmDeleteTitle',
		'rte-ck-videoPlaceholder-tooltip',
		'rte-ck-mut-add',
		'rte-ck-mut-mut',
		'rte-ck-widescreen-toggle',
		'rte-ck-spellchecker-moreSuggestions',
		'rte-ck-pasteText-title',
		'rte-ck-clipboard-pasteMsg',
		'rte-ck-format-tag_p',
		'rte-ck-format-tag_pre',
		'rte-ck-format-tag_h2',
		'rte-ck-format-tag_h3',
		'rte-ck-format-tag_h4',
		'rte-ck-format-tag_h5',
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/PhalanxII'
	
	
	);
