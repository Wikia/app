<?php

/**
 * Put categories, language links and allowed templates in a separate text box
 * while editing pages.
 *
 * @file
 * @ingroup Extensions
 * @author Magnus Manske and Alexandre Emsenhuber
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MetadataEdit',
	'author' => array( 'Magnus Manske', 'Alexandre Emsenhuber' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:MetadataEdit',
	'descriptionmsg' => 'metadataedit-desc',
	'version' => '0.1',
);

/**
 * Full name (including namespace) of the page containing templates names that
 * will be allowed as metadata
 */
$wgMetadataWhitelist = '';

/**
 * Restrict function to one or more namespaces, i.e. NS_MAIN
 */
$wgMetadataNamespaces = array();

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['MetadataEdit'] = $dir . 'MetadataEdit.i18n.php';

$wgAutoloadClasses['MetadataEditHooks'] = $dir . 'MetadataEdit.hooks.php';

$wgHooks['EditFormInitialText'][] = 'MetadataEditHooks::wfMetadataEditExtractFromArticle';
$wgHooks['EditPage::importFormData'][] = 'MetadataEditHooks::wfMetadataEditOnImportData';
$wgHooks['EditPage::attemptSave'][] = 'MetadataEditHooks::wfMetadataEditOnAttemptSave';
$wgHooks['EditPage::showEditForm:fields'][] = 'MetadataEditHooks::wfMetadataEditOnShowFields';
$wgHooks['EditPageGetPreviewText'][] = 'MetadataEditHooks::wfMetadataEditOnGetPreviewText';
$wgHooks['EditPageGetDiffText'][] = 'MetadataEditHooks::wfMetadataEditOnGetDiffText';

