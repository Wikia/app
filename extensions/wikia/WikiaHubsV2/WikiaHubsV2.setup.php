<?php
/**
 * WikiaHubs V2
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaHubs V2',
	'author' => 'Andrzej "nAndy" Łukaszewski,Marcin Maciejewski,Sebastian Marzjan',
	'description' => 'WikiaHubs V2',
	'version' => 1.0
);

// constroller classes
$app->registerClass('WikiaHubsV2Controller', $dir . 'WikiaHubsV2Controller.class.php');
$app->registerClass('WikiaHubsV2SuggestController', $dir . 'WikiaHubsV2SuggestController.class.php');

// hook classes
$app->registerClass('WikiaHubsV2Mobile', $dir . 'hooks/WikiaHubsV2MobileHooks.php');
$app->registerClass('WikiaHubsV2Hooks', $dir . 'hooks/WikiaHubsV2Hooks.php');

// model classes
$app->registerClass('WikiaHubsV2Article', $dir . 'models/WikiaHubsV2Article.class.php');
$app->registerClass('WikiaHubsV2Model', $dir . 'models/WikiaHubsV2Model.class.php');

$app->registerClass('WikiaHubsV2SuggestModel', $dir . 'models/WikiaHubsV2SuggestModel.class.php');

$app->registerClass('WikiaHubsV2SuggestModel', $dir . 'models/WikiaHubsV2SuggestModel.class.php');

$app->registerClass('WikiaHubsParserHelper', $dir . 'WikiaHubsParserHelper.class.php');

// i18n mapping
$app->registerExtensionMessageFile('WikiaHubsV2', $dir.'WikiaHubsV2.i18n.php');

// hooks
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaHubsV2Mobile', 'onWikiaMobileAssetsPackages');
$app->registerHook('ArticleFromTitle', 'WikiaHubsV2Hooks', 'onArticleFromTitle');
$app->registerHook('WikiaCanonicalHref', 'WikiaHubsV2Hooks', 'onWikiaCanonicalHref');
$app->registerHook('ParserFirstCallInit', 'WikiaHubsV2Hooks', 'onParserFirstCallInit');

// foreign file repo
$wgForeignFileRepos[] = array(
	'class'            => 'WikiaForeignDBViaLBRepo',
	'name'             => 'wikiahubsfiles',
	'directory'        => $wgWikiaHubsFileRepoDirectory,
	'url'              => 'http://images.wikia.com/central/images',
	'hashLevels'       => 2,
	'thumbScriptUrl'   => '',
	'transformVia404'  => true,
	'hasSharedCache'   => true,
	'descBaseUrl'      => $wgWikiaHubsFileRepoPath . 'wiki/File:',
	'fetchDescription' => true,
	'wiki'             => $wgWikiaHubsFileRepoDBName,
	'checkRedirects'   => false,
	'checkDuplicates'  => false,
);