<?php
/**
 * HtmlUi extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @license Apache 2.0
 * @version 0.1.0
 */

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'HtmlUi',
	'author' => array( 'Trevor Parscal' ),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:HtmlUi',
	'descriptionmsg' => 'htmlui-desc',
);
$dir = dirname( __FILE__ );
$wgAutoloadClasses['HtmlUi'] = "$dir/classes/HtmlUi.php";
$wgAutoloadClasses['HtmlUiField'] = "$dir/classes/HtmlUiField.php";
$wgAutoloadClasses['HtmlUiFieldset'] = "$dir/classes/HtmlUiFieldset.php";
$wgAutoloadClasses['HtmlUiForm'] = "$dir/classes/HtmlUiForm.php";
$wgAutoloadClasses['HtmlUiFormElement'] = "$dir/classes/HtmlUiFormElement.php";
$wgAutoloadClasses['HtmlUiFormElementCollection'] = "$dir/classes/HtmlUiFormElementCollection.php";
$wgAutoloadClasses['HtmlUiTemplate'] = "$dir/classes/HtmlUiTemplate.php";
$wgAutoloadClasses['HtmlUiHooks'] = "$dir/HtmlUi.hooks.php";
$wgExtensionMessagesFiles['HtmlUi'] = "$dir/HtmlUi.i18n.php";
$wgHooks['ResourceLoaderRegisterModules'][] = 'HtmlUiHooks::resourceLoaderRegisterModules';
