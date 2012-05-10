<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'PageLayoutBuilder',
	'author' => array( 'Tomasz Odrobny', 'Władysław Bodzek' ),
	//'url' => '',
	'descriptionmsg' => 'pagelayoutbuilder-desc',
	'version' => '0.0.1'
);

define("NS_PLB_LAYOUT", 902);

$wgExtraNamespaces[ NS_PLB_LAYOUT ] = "Layout";

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['SpecialPageLayoutBuilder'] = $dir . 'PageLayoutBuilderSpecialPage.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderForm'] = $dir . 'PageLayoutBuilderForm.class.php';
$wgAutoloadClasses['PageLayoutBuilderModel'] = $dir . 'PageLayoutBuilderModel.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderParser'] = $dir . 'PageLayoutBuilderParser.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderHelper'] = $dir . 'PageLayoutBuilderHelper.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderEditor'] = $dir . 'PageLayoutBuilderEditor.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderFormController'] = $dir . 'PageLayoutBuilderFormController.php';

$wgAutoloadClasses['simple_html_dom'] = $IP . '/lib/simplehtmldom/simple_html_dom.php'; # Simple parser to easy replace tags by media wiki text
$wgExtensionMessagesFiles['PageLayoutBuilder'] = $dir . 'PageLayoutBuilder.i18n.php';
$wgExtensionAliasesFiles['PageLayoutBuilder'] = $dir . 'PageLayoutBuilder.alias.php';
$wgSpecialPages['PageLayoutBuilder'] = 'SpecialPageLayoutBuilder'; # Let MediaWiki know about your new special page.
$wgSpecialPages['PageLayoutBuilderForm'] = 'PageLayoutBuilderForm';

/* JS messages */
$wgJSMessagesPackages['PageLayoutBuilder'] = array(
	'plb-special-form-cat-info',
);


/* job */
$wgAutoloadClasses['PageLayoutBuilderJob'] = $dir . 'PageLayoutBuilderJob.class.php'; # Tell MediaWiki to load the extension body.
$wgHooks[ "RevisionInsertComplete" ][] = "PageLayoutBuilderJob::revisionInsertComplete";
$wgJobClasses[ "PageLayoutBuilder" ] = "PageLayoutBuilderJob";

/* widgets */
$wgPLBwidgets = array();
$wgAutoloadClasses['LayoutWidgetBase'] = $dir . "widget/LayoutWidgetBase.class.php";

$wgPLBwidgets['plb_input'] = 'LayoutWidgetInput';
$wgAutoloadClasses['LayoutWidgetInput'] = $dir . "widget/LayoutWidgetInput.class.php";

$wgAutoloadClasses['LayoutWidgetMultiLineInput'] = $dir . "widget/LayoutWidgetMultiLineInput.class.php";
$wgAjaxExportList[] = 'LayoutWidgetImage::getUrlImageAjax';

$wgPLBwidgets['plb_image'] = 'LayoutWidgetImage';
$wgAutoloadClasses['LayoutWidgetImage'] = $dir . "widget/LayoutWidgetImage.class.php";
$wgPLBwidgets['plb_mlinput'] = 'LayoutWidgetMultiLineInput';

$wgPLBwidgets['plb_sinput'] = 'LayoutWidgetSelectInput';
$wgAutoloadClasses['LayoutWidgetSelectInput'] = $dir . "widget/LayoutWidgetSelectInput.class.php";

$wgPLBwidgets['plb_gallery'] = 'LayoutWidgetGallery';
$wgAutoloadClasses['LayoutWidgetGallery'] = $dir . "widget/LayoutWidgetGallery.class.php";
$wgAjaxExportList[] = 'LayoutWidgetGallery::renderForFormAjax';
$wgAjaxExportList[] = 'LayoutWidgetGallery::getGalleryDataAjax';

/* parser and reverse parser */

$wgAjaxExportList[] = 'PageLayoutBuilderEditor::closeHelpbox';

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'PageLayoutBuilderParser::init';
} else {
	$wgExtensionFunctions[] = 'PageLayoutBuilderParser::init';
}

/* Automatically set up database when PLB is switched on on some wiki */
$wgHooks[ 'LoadExtensionSchemaUpdates' ][] = 'PageLayoutBuilderHelper::schemaUpdate';

/* Set up the toolbar options with the proper caption and target link */
$wgHooks['MyTools::getDefaultTools'][] = 'PageLayoutBuilderHelper::onGetDefaultMyTools';
$wgHooks['UserCommand::SpecialPage::PageLayoutBuilder'][] = 'PageLayoutBuilderHelper::onGetUserCommandDetails';

/* Enhance edit pages with options to create new layout from currently edited article */
$wgHooks['EditPage::CategoryBox'][] = 'PageLayoutBuilderHelper::addNewButtonForArtilce';
$wgHooks['EditPage::showEditForm:initial'][] = 'PageLayoutBuilderHelper::onShowEditFormInitial';

/* Disallow editing layouts by unprivileged users */
$wgHooks['getUserPermissionsErrors'][] = 'PageLayoutBuilderHelper::getUserPermissionsErrors';

/* Automatically redirect users to proper edit pages when they click "Edit" button */
$wgHooks['AlternateEdit'][] = 'PageLayoutBuilderHelper::alternateEditHook';

/* Add all possible layouts to CreatePage types list */
#$wgHooks['CreatePage::FetchOptions'][] = 'PageLayoutBuilderHelper::createPageOptions'; // commented out due to BugId:21102

/* Set up verious elements on layout edit pages */
//$wgHooks['CategorySelect:beforeDisplayingEdit'][] = 'SpecialPageLayoutBuilder::beforeCategorySelect';
$wgHooks['EditPageBeforeEditButtons'][] = 'SpecialPageLayoutBuilder::addFormButton';

/* Hide layout from Category Select */
$wgHooks['CategoryPage::beforeCategoryData'][] = 'PageLayoutBuilderHelper::beforeCategoryData';

/* Handling of various layout edit special cases */
$wgHooks['ArticleRollbackComplete'][] = 'SpecialPageLayoutBuilder::onArticleRollbackComplete';


// --- Uncategorized hooks

$wgHooks['AlternateEdit'][] = 'PageLayoutBuilderForm::alternateEditHook';
$wgHooks['CategorySelect:beforeDisplayingView'][] = 'PageLayoutBuilderForm::blockCategorySelect';

$wgHooks['RTEUseDefaultPlaceholder'][] = 'PageLayoutBuilderParser::rteIsCustom';
$wgHooks['RTEcustomHandleTag'][] = 'PageLayoutBuilderParser::reverseParser';

$wgHooks['ParserAfterTidy'][] = 'PageLayoutBuilderParser::replaceTags';
$wgHooks['ParserAfterStrip'][] = 'PageLayoutBuilderParser::removeGalleryAndIPHook';
$wgHooks['Parser::FetchTemplateAndTitle'][] =  'PageLayoutBuilderParser::fetchTemplateAndTitleHook';

//$wgHooks['EditPageBeforeEditButtons'][] = 'PageLayoutBuilderForm::addFormButton';

//$wgHooks['EditPage::getContent::isUndo'][] = 'PageLayoutBuilderForm::isUndo';

$wgHooks['GetEditPageRailModuleList'][] = 'PageLayoutBuilderForm::getEditPageRailModuleList';
$wgHooks['CreateWikiLocalJob-complete'][] = 'PageLayoutBuilderHelper::copyLayout';

$wgHooks['BeforeEditEnhancements'][] = 'SpecialPageLayoutBuilder::onBeforeEditEnhancements';
//$wgHooks['GetRailModuleList'][] = 'SpecialPageLayoutBuilder::onGetRailModuleSpecialPageList';

$wgHooks['SpecialCreatePage::Subpage'][] = 'PageLayoutBuilderHelper::onCreatePageSubpage';

$wgHooks['ArticleSave'][] = 'PageLayoutBuilderHelper::onArticleSave';

$wgAjaxExportList[] = 'PageLayoutBuilderEditor::getPLBEditorData';

$wgDefaultLayoutWiki = 177;
