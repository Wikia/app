<?php
/**
 * WikiaHubs V3
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaHubs V3',
	'author' => 'Bartosz "V" Bentkowski, Damian Jóźwiak, Łukasz Konieczny, Sebastian Marzjan',
	'description' => 'WikiaHubs V3',
	'version' => 1.0
);

$wgAutoloadClasses['WikiaHubsV3Page'] =  $dir . 'WikiaHubsV3Page.class.php';

// constroller classes
$wgAutoloadClasses['WikiaHubsV3Controller'] =  $dir . 'WikiaHubsV3Controller.class.php';
$wgAutoloadClasses['WikiaHubsV3SuggestController'] =  $dir . 'WikiaHubsV3SuggestController.class.php';

// hook classes
$wgAutoloadClasses['WikiaHubsV3Hooks'] =  $dir . 'hooks/WikiaHubsV3Hooks.php';

// model classes
$wgAutoloadClasses['WikiaHubsV3Article'] =  $dir . 'models/WikiaHubsV3Article.class.php';
$wgAutoloadClasses['WikiaHubsV3HooksModel'] =  $dir . 'models/WikiaHubsV3HooksModel.class.php';
$wgAutoloadClasses['WikiaHubsModel'] =  $dir . '../WikiaHubsServices/models/WikiaHubsModel.class.php';

$wgAutoloadClasses['WikiaHubsV3SuggestModel'] =  $dir . 'models/WikiaHubsV3SuggestModel.class.php';

$wgAutoloadClasses['WikiaHubsParserHelper'] =  $dir . 'WikiaHubsParserHelper.class.php';

// i18n mapping
$wgExtensionMessagesFiles['WikiaHubsV3'] = $dir . 'WikiaHubsV3.i18n.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'WikiaHubsV3Hooks::onArticleFromTitle';
$wgHooks['WikiaCanonicalHref'][] = 'WikiaHubsV3Hooks::onWikiaCanonicalHref';
$wgHooks['ParserFirstCallInit'][] = 'WikiaHubsV3Hooks::onParserFirstCallInit';

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

