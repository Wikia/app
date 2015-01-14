<?php
/**
 * WikiaHubs services and classes used in Special:EditHub and WikiaHomePage
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Damian Jóźwiak
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'WikiaHubsServices',
	'author' => array(
		'Andrzej \'nAndy\' Łukaszewski',
		'Damian Jóźwiak',
		'Marcin Maciejewski',
		'Sebastian Marzjan'
	),
	'descriptionmsg' => 'wikia-hub-services-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaHubsServices',
);

$wgAutoloadClasses['EditHubModel'] =  $dir . 'models/EditHubModel.class.php';
$wgAutoloadClasses['WikiaHubsExploreModel'] =  $dir . 'models/WikiaHubsExploreModel.class.php';
$wgAutoloadClasses['WikiaHubsFeaturedvideoModel'] =  $dir . 'models/WikiaHubsFeaturedvideoModel.class.php';
$wgAutoloadClasses['WikiaHubsPollsModel'] =  $dir . 'models/WikiaHubsPollsModel.class.php';
$wgAutoloadClasses['WikiaHubsPopularvideosModel'] =  $dir . 'models/WikiaHubsPopularvideosModel.class.php';
$wgAutoloadClasses['WikiaHubsSliderModel'] =  $dir . 'models/WikiaHubsSliderModel.class.php';
$wgAutoloadClasses['WikiaHubsFromthecommunityModel'] =  $dir . 'models/WikiaHubsFromthecommunityModel.class.php';
$wgAutoloadClasses['WikiaHubsImageModel'] =  $dir . 'models/WikiaHubsImageModel.class.php';
$wgAutoloadClasses['WikiaHubsWAMModel'] =  $dir . 'models/WikiaHubsWAMModel.class.php';
$wgAutoloadClasses['WikiaHubsModel'] =  $dir . 'models/WikiaHubsModel.class.php';

$wgAutoloadClasses['WikiaHubsModuleService'] =  $dir . 'modules/WikiaHubsModuleService.class.php';
$wgAutoloadClasses['WikiaHubsModuleEditableService'] =  $dir . 'modules/WikiaHubsModuleEditableService.class.php';
$wgAutoloadClasses['WikiaHubsModuleNonEditableService'] =  $dir . 'modules/WikiaHubsModuleNonEditableService.class.php';
$wgAutoloadClasses['WikiaHubsModuleSliderService'] =  $dir . 'modules/WikiaHubsModuleSliderService.class.php';
$wgAutoloadClasses['WikiaHubsModuleWikiaspicksService'] =  $dir . 'modules/WikiaHubsModuleWikiaspicksService.class.php';
$wgAutoloadClasses['WikiaHubsModulePopularvideosService'] =  $dir . 'modules/WikiaHubsModulePopularvideosService.class.php';
$wgAutoloadClasses['WikiaHubsModuleExploreService'] =  $dir . 'modules/WikiaHubsModuleExploreService.class.php';
$wgAutoloadClasses['WikiaHubsModuleFeaturedvideoService'] =  $dir . 'modules/WikiaHubsModuleFeaturedvideoService.class.php';
$wgAutoloadClasses['WikiaHubsModuleFromthecommunityService'] =  $dir . 'modules/WikiaHubsModuleFromthecommunityService.class.php';
$wgAutoloadClasses['WikiaHubsModulePollsService'] =  $dir . 'modules/WikiaHubsModulePollsService.class.php';
$wgAutoloadClasses['WikiaHubsModuleWAMService'] =  $dir . 'modules/WikiaHubsModuleWAMService.class.php';
$wgAutoloadClasses['WikiaHubsModuleWikiastatsService'] =  $dir . 'modules/WikiaHubsModuleWikiastatsService.class.php';

$wgAutoloadClasses['WikiaHubsServicesHelper'] =  $dir . 'WikiaHubsServicesHelper.class.php';
$wgAutoloadClasses['WikiaHubsApiController'] = "{$IP}/extensions/wikia/WikiaHubsServices/api/WikiaHubsApiController.class.php";

$wgWikiaApiControllers['WikiaHubsApiController'] = "{$IP}/extensions/wikia/WikiaHubsServices/api/WikiaHubsApiController.class.php";

//message files
$wgExtensionMessagesFiles['WikiaHubsServices'] = $dir . 'WikiaHubsServices.i18n.php';

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
