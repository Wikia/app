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
	'author' => array(
		'Bartosz "V" Bentkowski',
		'Damian Jóźwiak', 
		'Łukasz Konieczny',
		'Sebastian Marzjan'
	),
	'descriptionmsg' => 'wikiahubs-v3-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaHubsV3'
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

// i18n mapping
$wgExtensionMessagesFiles['WikiaHubsV3'] = $dir . 'WikiaHubsV3.i18n.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'WikiaHubsV3Hooks::onArticleFromTitle';
$wgHooks['WikiaCanonicalHref'][] = 'WikiaHubsV3Hooks::onWikiaCanonicalHref';

