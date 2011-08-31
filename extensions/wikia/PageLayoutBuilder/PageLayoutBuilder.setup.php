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

$wgAutoloadClasses['PageLayoutBuilderSpecialPage'] = $dir . 'PageLayoutBuilderSpecialPage.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderForm'] = $dir . 'PageLayoutBuilderForm.class.php';
$wgAutoloadClasses['PageLayoutBuilderModel'] = $dir . 'PageLayoutBuilderModel.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderParser'] = $dir . 'PageLayoutBuilderParser.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderHelper'] = $dir . 'PageLayoutBuilderHelper.class.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['PageLayoutBuilderEditor'] = $dir . 'PageLayoutBuilderEditor.class.php'; # Tell MediaWiki to load the extension body.


$wgAutoloadClasses['PageLayoutBuilderFormModule'] = $dir . 'PageLayoutBuilderFormModule.php';

$wgAutoloadClasses['simple_html_dom'] = $dir . '3rdparty/simple_html_dom.php'; # Simple parser to easy replace tags by media wiki text
$wgExtensionMessagesFiles['PageLayoutBuilder'] = $dir . 'PageLayoutBuilder.i18n.php';
$wgExtensionAliasesFiles['PageLayoutBuilder'] = $dir . 'PageLayoutBuilder.alias.php';
$wgSpecialPages['PageLayoutBuilder'] = 'PageLayoutBuilderSpecialPage'; # Let MediaWiki know about your new special page.
$wgSpecialPages['PageLayoutBuilderForm'] = 'PageLayoutBuilderForm';
$wgSpecialPageGroups['PageLayoutBuilder'] = 'pagetools';

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

/* parser and revers parser */

$wgAjaxExportList[] = 'PageLayoutBuilderEditor::closeHelpbox';


if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'PageLayoutBuilderParser::init';
} else {
	$wgExtensionFunctions[] = 'PageLayoutBuilderParser::init';
}

$wgHooks[ 'WikiFactoryChanged' ][] = 'PageLayoutBuilderHelper::wikiFactoryChanged';
$wgHooks[ 'LoadExtensionSchemaUpdates' ][] = 'PageLayoutBuilderHelper::schemaUpdate';

$wgHooks['AlternateEdit'][] = 'PageLayoutBuilderSpecialPage::alternateEditHook';
$wgHooks['AlternateEdit'][] = 'PageLayoutBuilderForm::alternateEditHook';
$wgHooks['CategoryPage::beforeCategoryData'][] = 'PageLayoutBuilderSpecialPage::beforeCategoryData';
$wgHooks['CategorySelect:beforeDisplayingEdit'][] = 'PageLayoutBuilderSpecialPage::beforeCategorySelect';
$wgHooks['CategorySelect:beforeDisplayingView'][] = 'PageLayoutBuilderForm::blockCategorySelect';

$wgHooks['RTEUseDefaultPlaceholder'][] = 'PageLayoutBuilderParser::rteIsCustom';
$wgHooks['RTEcustomHandleTag'][] = 'PageLayoutBuilderParser::reverseParser';

$wgHooks['ParserAfterTidy'][] = 'PageLayoutBuilderParser::replaceTags';
$wgHooks['ParserAfterStrip'][] = 'PageLayoutBuilderParser::removeGalleryAndIPHook';
$wgHooks['Parser::FetchTemplateAndTitle'][] =  'PageLayoutBuilderParser::fetchTemplateAndTitleHook';

$wgHooks['ArticleRollbackComplete'][] = 'PageLayoutBuilderSpecialPage::rollbackHook';
$wgHooks['EditPageBeforeEditButtons'][] = 'PageLayoutBuilderForm::addFormButton';
$wgHooks['getUserPermissionsErrors'][] = 'PageLayoutBuilderSpecialPage::getUserPermissionsErrors';

$wgHooks['EditPageBeforeEditButtons'][] = 'PageLayoutBuilderSpecialPage::addFormButton';
$wgHooks['EditPage::CategoryBox'][] = 'PageLayoutBuilderSpecialPage::addNewButtonForArtilce';

$wgHooks['EditPage::getContent::isUndo'][] = 'PageLayoutBuilderForm::isUndo';

$wgHooks['CreatePage::FetchOptions'][] = 'PageLayoutBuilderHelper::createPageOptions';
$wgHooks['MyTools::getDefaultTools'][] = 'PageLayoutBuilderSpecialPage::myTools';
$wgHooks['UserCommand::SpecialPage::PageLayoutBuilder'][] = 'PageLayoutBuilderSpecialPage::myTools2';

$wgHooks['CreateWikiLocalJob-complete'][] = 'PageLayoutBuilderHelper::copyLayout';
$wgHooks['BeforeEditEnhancements'][] = 'PageLayoutBuilderSpecialPage::onBeforeEditEnhancements';

$wgHooks['SpecialCreatePage::Subpage'][] = 'PageLayoutBuilderHelper::onCreatePageSubpage';

$wgHooks['ArticleSave'][] = 'PageLayoutBuilderHelper::onArticleSave';

$wgAjaxExportList[] = 'PageLayoutBuilderEditor::getPLBEditorData';

$wgDefaultLayoutWiki = 177;
