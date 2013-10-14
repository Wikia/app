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

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaHubs V2',
	'author' => 'Andrzej "nAndy" Łukaszewski,Marcin Maciejewski,Sebastian Marzjan',
	'description' => 'WikiaHubs V2',
	'version' => 1.0
);

$wgAutoloadClasses['WikiaHubsV2Page'] =  $dir . 'WikiaHubsV2Page.class.php';

// constroller classes
$wgAutoloadClasses['WikiaHubsV2Controller'] =  $dir . 'WikiaHubsV2Controller.class.php';
$wgAutoloadClasses['WikiaHubsV2SuggestController'] =  $dir . 'WikiaHubsV2SuggestController.class.php';

// hook classes
$wgAutoloadClasses['WikiaHubsV2Hooks'] =  $dir . 'hooks/WikiaHubsV2Hooks.php';

// model classes
$wgAutoloadClasses['WikiaHubsV2Article'] =  $dir . 'models/WikiaHubsV2Article.class.php';
$wgAutoloadClasses['WikiaHubsV2Model'] =  $dir . 'models/WikiaHubsV2Model.class.php';
$wgAutoloadClasses['WikiaHubsV2HooksModel'] =  $dir . 'models/WikiaHubsV2HooksModel.class.php';

$wgAutoloadClasses['WikiaHubsV2SuggestModel'] =  $dir . 'models/WikiaHubsV2SuggestModel.class.php';

$wgAutoloadClasses['WikiaHubsParserHelper'] =  $dir . 'WikiaHubsParserHelper.class.php';
$wgAutoloadClasses['WikiaHubsApiController'] = $dir . 'api/WikiaHubsApiController.class.php';

// i18n mapping
$wgExtensionMessagesFiles['WikiaHubsV2'] = $dir.'WikiaHubsV2.i18n.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'WikiaHubsV2Hooks::onArticleFromTitle';
$wgHooks['WikiaCanonicalHref'][] = 'WikiaHubsV2Hooks::onWikiaCanonicalHref';
$wgHooks['ParserFirstCallInit'][] = 'WikiaHubsV2Hooks::onParserFirstCallInit';

$wgWikiaApiControllers['WikiaHubsApiController'] = "{$IP}/includes/wikia/api/WikiaHubsApiController.class.php";

// foreign file repo
$wgForeignFileRepos[] = array(
	'class'            => 'WikiaForeignDBViaLBRepo',
	'name'             => 'wikiahubsfiles',
	'directory'        => $wgWikiaHubsFileRepoDirectory,
	'url'              => 'http://images.wikia.com/' . $wgWikiaHubsFileRepoDBName . '/images',
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

