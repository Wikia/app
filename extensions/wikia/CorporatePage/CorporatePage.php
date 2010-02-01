<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CorporatePage',
	'author' => 'Tomasz Odrobny',
	'url' => '',
	'description' => 'global page for wikia.com',
	'descriptionmsg' => 'myextension-desc',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['CorporatePageHelper']  = $dir . 'CorporatePageHelper.class.php';
$wgExtensionMessagesFiles['CorporatePage'] = $dir . 'CorporatePage.i18n.php'; 
$wgHooks['MakeGlobalVariablesScript'][] = 'CorporatePageHelper::jsVars';
$wgHooks['ArticleFromTitle'][] = 'CorporatePageHelper::ArticleFromTitle';
$wgHooks['MessageCacheReplace'][] = 'CorporatePageHelper::clearMessageCache';
$wgAjaxExportList[] = 'CorporatePageHelper::blockArticle';