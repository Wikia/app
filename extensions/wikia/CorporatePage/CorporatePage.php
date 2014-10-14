<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CorporatePage',
	'author' => 'Tomasz Odrobny',
	'description' => 'global page for wikia.com',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';

// this should be set in CommonSettings.php / WikiFactory
if ( !isset( $wgCorporatePageRedirectWiki ) ) {
	$wgCorporatePageRedirectWiki = "http://community.wikia.com/wiki/";
}

$wgAutoloadClasses['CorporatePageHelper']  = $dir . 'CorporatePageHelper.class.php';
$wgAutoloadClasses['CorporateSiteController'] = $dir . 'modules/CorporateSiteController.class.php';
$wgAutoloadClasses['BlogsInHubsController'] = $dir . 'modules/BlogsInHubsController.class.php';
$wgAutoloadClasses['BlogsInHubsService'] = $dir . 'services/BlogsInHubsService.class.php';

$wgExtensionMessagesFiles['CorporatePage'] = $dir . 'CorporatePage.i18n.php';
$wgHooks['MakeGlobalVariablesScript'][] = 'CorporatePageHelper::jsVars';
$wgHooks['ArticleFromTitle'][] = 'CorporatePageHelper::ArticleFromTitle';
$wgHooks['ArticleSaveComplete'][] = 'CorporatePageHelper::clearMessageCache';
$wgHooks['OutputPageCheckLastModified'][] = 'CorporatePageHelper::forcePageReload';
$wgAjaxExportList[] = 'CorporatePageHelper::blockArticle';

$app = F::app();
$app->registerHook('MessageCacheReplace', 'BlogsInHubsService', 'onMessageCacheReplace');
$app->registerHook('ArticleCommentCheck', 'CorporatePageHelper', 'onArticleCommentCheck');
